<?php
namespace K5\Modules\Micro;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ControllerBase extends \Phalcon\Mvc\Controller
{
    /**
     * These functions are available for multiple controllers
     */

    /**
     * Register LOG in another DB
     */
    public function registerLog()
    {
        // gets user token
        $token_decoded = $this->decodeToken($this->getToken());

        // Gets URL route from request
        $url = $this->request->get();

        // Initiates log db transaction
        $this->db_log->begin();
        $newLog = new \K5\Modules\Micro\Model\Logs();
        $newLog->username = $token_decoded->username_username; // gets username
        $newLog->route = $url['_url']; // gets route
        $newLog->date = $this->getNowDateTime();
        if (!$newLog->save()) {
            // rollback transaction
            $this->db_log->rollback();
            // Send errors
            $errors = array();
            foreach ($newLog->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }
            $this->buildErrorResponse(400, 'common.COULD_NOT_BE_CREATED', $errors);
        }
        // Commit the transaction
        $this->db_log->commit();
    }

    /**
     * Try to save data in DB
     */
    public function tryToSaveData($element, $customMessage = 'common.THERE_HAS_BEEN_AN_ERROR')
    {
        if (!$element->save()) {
            // Send errors
            $errors = array();
            foreach ($element->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }
            $this->buildErrorResponse(400, $customMessage, $errors);
        }
        return true;
    }

    /**
     * Try to delete data in DB
     */
    public function tryToDeleteData($element)
    {
        if (!$element->delete()) {
            // Send errors
            $errors = array();
            foreach ($element->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }
            $this->buildErrorResponse(400, 'common.COULD_NOT_BE_DELETED', $errors);
        }
        return true;
    }

    /**
     * Build options for listings
     */
    public function buildOptions($defaultSort, $sort, $order, $limit, $offset)
    {
        $options = [];
        $rows = 5;
        $order_by = $defaultSort;
        $offset = 0;
        $limit = $offset + $rows;

        // Handles Sort querystring (order_by)
        if ($sort != null && $order != null) {
            $order_by = $sort . ' ' . $order;
        }

        // Gets rows_per_page
        if ($this->request->get('limit') != null) {
            $rows = $this->getQueryLimit($this->request->get('limit'));
            $limit = $rows;
        }

        // Calculate the offset and limit
        if ($this->request->get('offset') != null) {
            $offset = $this->request->get('offset');
            $limit = $rows;
        }
        $options = $this->array_push_assoc($options, 'rows', $rows);
        $options = $this->array_push_assoc($options, 'order_by', $order_by);
        $options = $this->array_push_assoc($options, 'offset', $offset);
        $options = $this->array_push_assoc($options, 'limit', $limit);
        return $options;
    }

    /**
     * Build filters for listings
     */
    public function buildFilters($filter)
    {
        $filters = [];
        $conditions = [];
        $parameters = [];

        // Filters simple (no left joins needed)
        if ($filter != null) {
            $filter = json_decode($filter, true);
            foreach ($filter as $key => $value) {
                array_push($conditions, $key . ' LIKE :' . $key . ':');
                $parameters = $this->array_push_assoc($parameters, $key, '%' . trim($value) . '%');
            }
            $conditions = implode(' AND ', $conditions);
        }
        $filters = $this->array_push_assoc($filters, 'conditions', $conditions);
        $filters = $this->array_push_assoc($filters, 'parameters', $parameters);
        return $filters;
    }

    /**
     * Build listing object
     */
    public function buildListingObject($elements, $rows, $total)
    {
        $data = [];
        $data = $this->array_push_assoc($data, 'rows_per_page', $rows);
        $data = $this->array_push_assoc($data, 'total_rows', $total);
        $data = $this->array_push_assoc($data, 'rows', $elements->toArray());
        return $data;
    }

    /**
     * Calculates total rows for an specified model
     */
    public function calculateTotalElements($model, $conditions, $parameters)
    {
        $total = $model::count(
            array(
                $conditions,
                'bind' => $parameters,
            )
        );
        return $total;
    }

    /**
     * Find element by ID from an specified model
     */
    public function findElementById($model, $id)
    {
        $conditions = 'id = :id:';
        $parameters = array(
            'id' => $id,
        );
        $element = $model::findFirst(
            array(
                $conditions,
                'bind' => $parameters,
            )
        );
        if (!$element) {
            $this->buildErrorResponse(404, 'common.NOT_FOUND');
        }
        return $element;
    }

    /**
     * Find elements from an specified model
     */
    public function findElements($model, $conditions, $parameters, $columns, $order_by, $offset, $limit)
    {
        $elements = $model::find(
            array(
                $conditions,
                'bind' => $parameters,
                'columns' => $columns,
                'order' => $order_by,
                'offset' => $offset,
                'limit' => $limit,
            )
        );
        if (!$elements) {
            $this->buildErrorResponse(404, 'common.NO_RECORDS');
        }
        return $elements;
    }

    /**
     * Check if there is missing data from the request
     */
    public function checkForEmptyData($array)
    {
        foreach ($array as $value) {
            if (empty($value)) {
                $this->buildErrorResponse(400, 'common.INCOMPLETE_DATA_RECEIVED');
            }
        }
    }

    /**
     * uset a properties from an array
     */
    public function unsetPropertyFromArray($array, $remove)
    {
        foreach ($remove as $value) {
            unset($array[$value]);
        }
        return $array;
    }

    /**
     * Generated NOW datetime based on a timezone
     */
    public function getNowDateTime()
    {
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('UTC'));
        $now = $now->format('Y-m-d H:i:s');
        return $now;
    }

    /**
     * Generated NOW datetime based on a timezone and added XX minutes
     */
    public function getNowDateTimePlusMinutes($minutes_to_add)
    {
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('UTC'));
        $now->add(new \DateInterval('PT' . $minutes_to_add . 'M'));
        $now = $now->format('Y-m-d H:i:s');
        return $now;
    }

    /**
     * Converts ISO8601 date to DateTime UTC
     */
    public function iso8601_to_utc($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    /**
     * Converts DateTime UTC date to ISO8601
     */
    public function utc_to_iso8601($date)
    {
        if (!empty($date) && ($date != '0000-00-00') && ($date != '0000-00-00 00:00') && ($date != '0000-00-00 00:00:00')) {
            $datetime = new \DateTime($date);
            return $datetime->format('Y-m-d\TH:i:s\Z');
        }
        return null;
    }

    /**
     * Array push associative.
     */
    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    /**
     * Generates limits for queries.
     */
    public function getQueryLimit($limit)
    {
        $setLimit = 5;
        if ($limit != '') {
            if ($limit > 150) {
                $setLimit = 150;
            }
            if ($limit <= 0) {
                $setLimit = 1;
            }
            if (($limit >= 1) && ($limit <= 150)) {
                $setLimit = $limit;
            }
        }
        return $setLimit;
    }

    /**
     * Verifies if is get request
     */
    public function initializeGet()
    {
        if (!$this->request->isGet()) {
            die();
        }
    }

    /**
     * Verifies if is post request
     */
    public function initializePost()
    {
        if (!$this->request->isPost()) {
            die();
        }
    }

    /**
     * Verifies if is patch request
     */
    public function initializePatch()
    {
        if (!$this->request->isPatch()) {
            die();
        }
    }

    /**
     * Verifies if is patch request
     */
    public function initializeDelete()
    {
        if (!$this->request->isDelete()) {
            die();
        }
    }

    /**
     * Encode token.
     */
    public function encodeToken($data)
    {
        // Encode token
        $token_encoded = $this->jwt->encode($data, $this->tokenConfig['secret']);
        $token_encoded = $this->mycrypt->encryptBase64($token_encoded);
        return $token_encoded;
    }

    /**
     * Decode token.
     */
    public function decodeToken($token)
    {
        // Decode token
        $token = $this->mycrypt->decryptBase64($token);
        $token = $this->jwt->decode($token, $this->tokenConfig['secret'], array('HS256'));
        return $token;
    }

    /**
     * Returns token from the request.
     * Uses token URL query field, or Authorization header
     */
    public function getToken()
    {
        $authHeader = $this->request->getHeader('Authorization');
        $xcsrf = $this->request->getHeader('X-Csrf-Token');
        $authQuery = $this->request->get('token');
        if($xcsrf && strlen($xcsrf) > 10) {
            $authQuery = $xcsrf;
        }

        return $authQuery ? $authQuery : $this->parseBearerValue($authHeader);
    }

    public function parseBearerValue($string)
    {
        if (strpos(trim($string), 'Bearer') !== 0) {
            return null;
        }
        return preg_replace('/.*\s/', '', $string);
    }

    /**
     * Builds success responses.
     */
    public function buildSuccessResponse($code, $messages, $data = '')
    {
        switch ($code) {
            case 200:
                $status = 'OK';
                break;
            case 201:
                $status = 'Created';
                break;
            case 202:
                break;
        }
        $generated = array(
            'status' => $status,
            'code' => $code,
            'messages' => $messages,
            'data' => $data,
        );
        $this->response->setStatusCode($code, $status)->sendHeaders();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent($generated, JSON_NUMERIC_CHECK)->send();
        die();
    }

    /**
     * Builds error responses.
     */
    public function buildErrorResponse($code, $messages, $data = '')
    {
        switch ($code) {
            case 400:
                $status = 'Bad Request';
                break;
            case 401:
                $status = 'Unauthorized';
                break;
            case 403:
                $status = 'Forbidden';
                break;
            case 404:
                $status = 'Not Found';
                break;
            case 409:
                $status = 'Conflict';
                break;
        }
        $generated = array(
            'status' => $status,
            'code' => $code,
            'messages' => $messages,
            'data' => $data,
        );
        $this->response->setStatusCode($code, $status)->sendHeaders();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent($generated, JSON_NUMERIC_CHECK)->send();
        die();
    }

    /**
     * Private functions
     */
    public function checkIfHeadersExist($headers)
    {
        return (!isset($headers['Authorization']) || empty($headers['Authorization'])) ? $this->buildErrorResponse(403, 'common.HEADER_AUTHORIZATION_NOT_SENT') : true;
    }

    public function findUser($credentials)
    {

        $username = $credentials['username'];

        $conditions = 'username = :username:';
        $parameters = array(
            'username' => $username,
        );
        $user = \K5\Modules\Micro\Model\Users::findFirst(
            array(
                $conditions,
                'bind' => $parameters,
            )
        );
        return (!$user) ? $this->buildErrorResponse(404, 'login.USER_IS_NOT_REGISTERED') : $user;
    }

    public function getUserPassword($credentials)
    {
        return $credentials['password'];
    }

    public function checkIfUserIsNotBlocked($user)
    {
        $block_expires = strtotime($user->block_expires);
        $now = strtotime($this->getNowDateTime());
        return ($block_expires > $now) ? $this->buildErrorResponse(403, 'login.USER_BLOCKED') : true;
    }

    public function checkIfUserIsAuthorized($user)
    {
        return ($user->authorised == 0) ? $this->buildErrorResponse(403, 'login.USER_UNAUTHORIZED') : true;
    }

    public function addOneLoginAttempt($user)
    {
        $user->login_attempts = $user->login_attempts + 1;
        $this->tryToSaveData($user);
        return $user->login_attempts;
    }

    public function addXMinutesBlockToUser($minutes, $user)
    {
        $user->block_expires = $this->getNowDateTimePlusMinutes($minutes);
        if ($this->tryToSaveData($user)) {
            $this->buildErrorResponse(400, 'login.TOO_MANY_FAILED_LOGIN_ATTEMPTS');
        }
    }

    public function checkPassword($password, $user)
    {
        if (!password_verify($password, $user->password)) {
            $login_attempts = $this->addOneLoginAttempt($user);
            ($login_attempts <= 4) ? $this->buildErrorResponse(400, 'login.WRONG_USER_PASSWORD') : $this->addXMinutesBlockToUser(120, $user);
        }
    }

    public function checkIfPasswordNeedsRehash($password, $user)
    {
        $options = [
            'cost' => 10, // the default cost is 10, max is 12.
        ];
        if (password_needs_rehash($user->password, PASSWORD_DEFAULT, $options)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT, $options);
            $user->password = $newHash;
            $this->tryToSaveData($user);
        }
    }

    public function buildUserData($user)
    {
        $user_data = array(
            'id' => $user->id,
            'username' => $user->username
        );
        return $user_data;
    }

    public function buildTokenData($user,$domain,$hede)
    {
        // issue at time and expires (token)
        $iat = strtotime($this->getNowDateTime());
        $exp = strtotime('+' . $this->tokenConfig['expiration_time'] . ' seconds', $iat);

        $token_data = array(
            'iss' => $this->tokenConfig['iss'],
            'aud' => $this->tokenConfig['aud'],
            'iat' => $iat,
            'exp' => $exp,
            'username_username' => $user->username,
            'username_level' => $user->level,
            'domain'=> $domain['domain'],
            'configs'=> $domain['configs'],
            'frontUser'=> null,
            'rand' => rand() . microtime(),
        );
        return $token_data;
    }

    public function resetLoginAttempts($user)
    {
        $user->login_attempts = 0;
        $this->tryToSaveData($user);
    }

    public function registerNewUserAccess($user)
    {
        $headers = $this->request->getHeaders();
        $newAccess = new \K5\Modules\Micro\Model\UsersAccess();
        $newAccess->username = $user->username;
        $newAccess->ip = (isset($headers['Http-Client-Ip']) || !empty($headers['Http-Client-Ip'])) ? $headers['Http-Client-Ip'] : $this->request->getClientAddress();
        $newAccess->domain = (isset($headers['Http-Client-Domain']) || !empty($headers['Http-Client-Domain'])) ? $headers['Http-Client-Domain'] : gethostbyaddr($this->request->getClientAddress());
        $newAccess->country = (isset($headers['Http-Client-Country']) || !empty($headers['Http-Client-Country'])) ? $headers['Http-Client-Country'] : ($this->request->getServer('HTTP_CF_IPCOUNTRY') !== null) ? $this->request->getServer('HTTP_CF_IPCOUNTRY') : 'XX';
        $newAccess->browser = $this->request->getUserAgent();
        $newAccess->date = $this->getNowDateTime();
        $this->tryToSaveData($newAccess);
    }
}
