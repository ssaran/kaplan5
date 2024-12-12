<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 24.01.2018
 * Time: 14:48
 */

namespace K5\Helper;

class Seeder
{
    public array $HumanNames = [];
    public array $Surnames = [];
    public array $VehicleModels = [];
    public array $CompanyNames = [];
    public array $EmailProviders = [];
    public array $StreetNames = [];
    public array $TaxOffices = [];
    public array $ListCity = [];
    public array $ListCounty = [];
    public array $ListArea = [];
    public array $ListNeigh = [];
    public array $Personel = [];
    public array $DeliveryLabels = [];

    private array $_email = [];
    private array $_doms = [];

    public function __construct()
    {
        $this->DeliveryLabels = ['Şube', 'Şantiye', 'Depo', 'Garaj', 'Fabrika', 'Atölye', 'Kurs', 'Ofis'];

        $this->EmailProviders = ['gmail.com', 'outlook.com', 'hotmail.com', 'mynet.com', 'yahoo.com', 'aol.com', 'zimbra.fr'];

        $this->Surnames = ["Şen", "Kandemir", "Çevik", "Erkuran", "Tüten", "Öztürk", "Yüzbaşioğlu", "Vural", "Yücel", "Sönmez",
            "Ertekin", "Dede", "Uyanik", "Aslan", "Akbulut", "Orhon", "Uz", "Yavuz", "Erdem", "Kulaç", "Kaya", "Selvi", "Akpinar",
            "Abacioğlu", "Çay", "Işik", "Özer", "Özdemir", "Öztürk", "Tahtaci", "Büyükcam", "Kulaksiz", "Aksel", "Eroğlu",
            "Karakum", "Dal", "Öcal", "Ayhan", "Yiğit", "Yarbil", "Canacankatan", "Gümüşay", "Murt", "Halhalli", "Uluöz",
            "Şeyhanli", "Çalişkantürk", "Yilmaz", "Saraçoğlu", "Sezer", "Doğan", "Demir", "Kayayurt", "Sürüm", "Yavaşi",
            "Turgut", "Şen Tanrikulu", "Barbaros", "Aldinç", "Tekin", "Gülşan", "Küfeciler", "Almacioğlu", "Çildir", "Türkdoğan",
            "Kaya", "Öner", "Şeliman", "Yaman", "Atik", "Yiğit", "Giray", "Yalçinkaya", "Kiliç", "Şentürk", "Karabağ", "Değirmenci",
            "Boduroğlu", "Yildiz", "Güler", "Eraslan", "Üzer", "Pişirgen", "Adanir", "Koç", "Korkmaz", "Yenidoğan", "Aydoğan",
            "Acarbulut", "Erge", "Erdoğan", "Kuşku", "Pektaş", "Kayacan", "Gülen", "Doğan", "Candan", "Temel", "Yenigün",
            "Yildirim", "Beder", "Akinci", "Özdemir", "Onuk", "Aydoğan", "Yilmaz", "Cömert", "Topal", "Karahan", "Şahin",
            "Çetin", "Aytaç", "Kişi", "Gündüz", "Ak", "Urfali", "Karaman", "Memetoğlu", "Kazbek", "Kireççi", "Akin",
            "Yadigaroğlu", "Yüksel", "Babuş", "Kaplan", "Aköz", "Kartal", "Bilgiç", "Erden", "Tuğcugil", "Kumral", "Erbaş",
            "Oral", "Kilaç", "Cengiz", "Yildirim", "Bağci", "Balaban", "Kaya", "Balci", "Tüfekçi", "Atay", "Yarar", "Sever",
            "Yildirim", "Kaşdoğan", "Arkan", "Tutaş", "Öztürk", "Havas", "Seçir", "Yildiz", "Soykamer", "Bektaş", "Berk", "Gül",
            "Cengiz", "Çolak", "Bulut", "Sari", "Akyol", "Bağcik", "Kutluyurdu", "Demirgan", "Gerilmez", "Düzkalir", "Köksoy",
            "Gülşen", "Akar", "Özdoğan", "Tönge", "Yasa", "Önvermez", "Yildirim", "Biçer", "Karademir", "Alimli", "Akgül",
            "Hancioğlu", "Batçik", "Olpak", "Bolat", "Arslan", "Siğa", "Mercan", "Bozkurter", "Güler", "Erginel", "Şahin",
            "Kadak", "Hepkaya", "Bayram", "Eser", "Gider", "Kurt", "Ellialti", "Demirtaş", "Arga", "Aluçlu", "Mutlu", "Engiz",
            "Çipe", "Uysal", "Başer", "Arslan", "Gözkaya", "Ulutaş", "Pirim", "Üstün", "Kizmazoğlu", "Uluba", "Arslan",
            "Karaoğlu", "Özsoy", "Yalçin", "Saf", "Vural", "Demirtaş", "Gençpinar", "Akaslan", "Uyğun", "Atay", "Baymak", "Atay",
            "Güvenç", "Özcan", "Başman", "Ünal", "Gündoğdu", "Çelik", "Taşkin", "Çetin", "Sari", "Karakoyun", "Ekici", "Aydiner",
            "Aktaş", "Belgemen", "Çetin", "Oflaz", "Buğrul", "Baysoy", "Bükülmez", "Yilmaz", "Biçakçi", "Kara", "Dayar", "Ateş",
            "Binboğa", "Kiziltepe", "Kaya", "Abseyi", "Uçan", "Öztürk", "Taş", "Ceylan", "Kiliç", "Erol", "Tayfun", "Kaya",
            "Karakurt", "Budunoğlu", "Saygin", "Eryavuz", "Çiçek", "Yilmaz", "Çelik", "Ünsal", "Alpinar", "Cindemir", "Akduman",
            "Uyar", "Tülpar", "Azak", "Eren", "Gözcü", "Baysal", "Tuncel", "Çetemen", "Yılmaz", "Giniş", "Uzun", "Nasıroğlu",
            "Sezgin", "Öztürk", "Yıldırım", "Uzun", "Bulur", "Duysak", "Yenin", "Demirel", "Sak", "Kocabaş", "Saraç", "Kayıkçı",
            "Yurt", "İlkay", "Tavşan", "Alay", "Ertem"];

        $this->HumanNames = array(
            'w' =>
                array(
                    'Jale' => 'Jale',
                    'Gamze' => 'Gamze',
                    'Birsen' => 'Birsen',
                    'Reyhan' => 'Reyhan',
                    'Gülşah' => 'Gülşah',
                    'Nalan' => 'Nalan',
                    'Şenay' => 'Şenay',
                    'Irazca' => 'Irazca',
                    'Hatice' => 'Hatice',
                    'Rezan' => 'Rezan',
                    'Pinar' => 'Pinar',
                    'Mediha' => 'Mediha',
                    'Nagihan' => 'Nagihan',
                    'Ceren' => 'Ceren',
                    'Bengü' => 'Bengü',
                    'Dilek' => 'Dilek',
                    'Güldehen' => 'Güldehen',
                    'Selma' => 'Selma',
                    'Tuğsem' => 'Tuğsem',
                    'Gülçin' => 'Gülçin',
                    'Ebru' => 'Ebru',
                    'Tümay' => 'Tümay',
                    'Başak' => 'Başak',
                    'Ayşegül' => 'Ayşegül',
                    'Ülkü' => 'Ülkü',
                    'Fulya' => 'Fulya',
                    'Burcu' => 'Burcu',
                    'Zeynep' => 'Zeynep',
                    'Gülay' => 'Gülay',
                    'Rabia' => 'Rabia',
                    'Sevda' => 'Sevda',
                    'Asli' => 'Asli',
                    'Tuba' => 'Tuba',
                    'Sevgi' => 'Sevgi',
                    'Ferda' => 'Ferda',
                    'Ezgi' => 'Ezgi',
                    'Aysun' => 'Aysun',
                    'Seda' => 'Seda',
                    'Özlem' => 'Özlem',
                    'Özden' => 'Özden',
                    'Senem' => 'Senem',
                    'Emel' => 'Emel',
                    'Nuray' => 'Nuray',
                    'Aydoğan' => 'Aydoğan',
                    'Deniz' => 'Deniz',
                    'İlknur' => 'İlknur',
                    'Şeyma' => 'Şeyma',
                    'Dilber' => 'Dilber',
                    'Elif' => 'Elif',
                    'Mahperi' => 'Mahperi',
                    'Sevil' => 'Sevil',
                    'Süheyla' => 'Süheyla',
                    'İlkay' => 'İlkay',
                    'Hale' => 'Hale',
                    'Sedef' => 'Sedef',
                    'Serpil' => 'Serpil',
                    'Zülfiye' => 'Zülfiye',
                    'Sultan' => 'Sultan',
                    'Yildiz' => 'Yildiz',
                    'Ceyhan' => 'Ceyhan',
                    'Esin' => 'Esin',
                    'Saliha' => 'Saliha',
                    'Belgin' => 'Belgin',
                    'Gonca' => 'Gonca',
                    'Esra' => 'Esra',
                    'Birgül' => 'Birgül',
                    'Demet' => 'Demet',
                    'Sonay' => 'Sonay',
                    'Serçin' => 'Serçin',
                    'Münever' => 'Münever',
                    'Özge' => 'Özge',
                    'Zeliha' => 'Zeliha',
                    'Aybüke' => 'Aybüke',
                    'Hasibe' => 'Hasibe',
                    'Zühal' => 'Zühal',
                    'Ayla' => 'Ayla',
                    'Beyza' => 'Beyza',
                    'Diana' => 'Diana',
                    'Semra' => 'Semra',
                ),
            'm' =>
                array(
                    'Ali' => 'Ali',
                    'Mahmut' => 'Mahmut',
                    'Miraç' => 'Miraç',
                    'Yücel' => 'Yücel',
                    'Kubilay' => 'Kubilay',
                    'Hayati' => 'Hayati',
                    'Serdal' => 'Serdal',
                    'Bünyamin' => 'Bünyamin',
                    'Özgür' => 'Özgür',
                    'Ferdi' => 'Ferdi',
                    'İlhan' => 'İlhan',
                    'Semih' => 'Semih',
                    'Ergün' => 'Ergün',
                    'Fatih' => 'Fatih',
                    'Serkan' => 'Serkan',
                    'Emre' => 'Emre',
                    'Bahattin' => 'Bahattin',
                    'Bariş' => 'Bariş',
                    'Fuat' => 'Fuat',
                    'Gökhan' => 'Gökhan',
                    'Orhan' => 'Orhan',
                    'Mehmet' => 'Mehmet',
                    'Evren' => 'Evren',
                    'Oktay' => 'Oktay',
                    'Harun' => 'Harun',
                    'Yavuz' => 'Yavuz',
                    'Umut' => 'Umut',
                    'Mesude' => 'Mesude',
                    'Mustafa' => 'Mustafa',
                    'Ufuk' => 'Ufuk',
                    'Hasan' => 'Hasan',
                    'Kamil' => 'Kamil',
                    'Nebi' => 'Nebi',
                    'Özcan' => 'Özcan',
                    'Çetin' => 'Çetin',
                    'Tarkan' => 'Tarkan',
                    'Ural' => 'Ural',
                    'Yahya' => 'Yahya',
                    'Gökmen' => 'Gökmen',
                    'Bülent' => 'Bülent',
                    'Erol' => 'Erol',
                    'Bahri' => 'Bahri',
                    'İsmail' => 'İsmail',
                    'Murat' => 'Murat',
                    'Ahmet' => 'Ahmet',
                    'Evrim' => 'Evrim',
                    'Yaser' => 'Yaser',
                    'Özhan' => 'Özhan',
                    'Aksel' => 'Aksel',
                    'Taylan' => 'Taylan',
                    'Yilmaz' => 'Yilmaz',
                    'Bayram' => 'Bayram',
                    'Serhat' => 'Serhat',
                    'Engin' => 'Engin',
                    'Halil' => 'Halil',
                    'Bilge' => 'Bilge',
                    'Koray' => 'Koray',
                    'Kürşat' => 'Kürşat',
                    'Seyfi' => 'Seyfi',
                    'Ersagun' => 'Ersagun',
                    'Mesut' => 'Mesut',
                    'Onur' => 'Onur',
                    'İbrahim' => 'İbrahim',
                    'Volkan' => 'Volkan',
                    'Yener' => 'Yener',
                    'Fadil' => 'Fadil',
                    'Derviş' => 'Derviş',
                    'Mehri' => 'Mehri',
                    'Serdar' => 'Serdar',
                    'Onat' => 'Onat',
                    'Şükrü' => 'Şükrü',
                    'Aydin' => 'Aydin',
                    'Aykan' => 'Aykan',
                    'Selçuk' => 'Selçuk',
                    'Nezih' => 'Nezih',
                    'Timur' => 'Timur', 'Erhan' => 'Erhan', 'Mutlu' => 'Mutlu', 'Yasin' => 'Yasin', 'Seçkin' => 'Seçkin',
                    'Ümit' => 'Ümit', 'Coşkun' => 'Coşkun', 'Gürkan' => 'Gürkan', 'Nazim' => 'Nazim', 'Osman' => 'Osman', 'Eray' => 'Eray',
                )
        );


        $this->VehicleModels = [
            "Ford:Transit:1993:2017:15:4:1", "Ford:Connect:2001:2017:7:3:1", "Fiat:Doblo:1993:2017:6:3:1",
            "Fiat:Ducato:2005:2017:16:4:1", "Fiat:Fiorino:2004:2017:5:3:1", "Peugeot:J9:1993:2017:18:6:1",
            "Peugeot:Partner:1998:2017:8:3:1", "Peugeot:Bipper:2004:2017:8:3:1", "Renault:Traffic:2003:2017:14:4:1",
            "Renault:Kango:2002:2017:7:4:1", "Dacia:Lodgy:2014:2017:7:3:1", "Dacia:Dokker:2014:2017:7:3:1",
            "Dacia:Logan-MVC:2010:2017:7:2:1", "Mercedes:Sprinter:2001:2017:13:4:1", "Ford:Granada:1972:1985:12:2:3",
            "Mercedes:S:1972:2018:15:2:3"
        ];

        $this->CompanyNames = ["A-PLAS GENEL OTOMOTİV MAMÜLLERİ SAN.TİC.LTD.ŞTİ.Oto Plastik ", "A.N.Y TEKSTİL SANAYİ VE TİCARET PAZARLAMA A.Ş.",
            "A.R. ALTINLILAR TEKS.LTD.ŞTİ.", "ACARER TEKSTİL SAN.TİC.LTD.ŞTİ.", "ACARSOY TEKSTİL TİCARET VE SANAYİ A.Ş.",
            "ACARSOYLU TEKSTİL SAN.TİC.LTD.ŞTİ.", "ADAL TEK. KONF. LTD. ŞTİ.", "AHSEN TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "AK-İŞ BOYA SAN.TİC.A.Ş.Boya", "AK-İZO YALITIM SİSTEMLERİ TİC.A.Ş.", "AK-TAŞ TEKSTİL SAN.DIŞ.TİC.LTD.ŞTİ.",
            "AKARCA TEKSTİL SAN.TİC.LTD.ŞTİ.", "AKAYTEKS CILIK VE EMPRİMECİLİK A.Ş.", "AKDÜLGER OTOMOTİV YAN SA.TİC.A.Ş.",
            "AKE SPOR MALZEMELERİ SAN.TİC.LTD. ŞTİ.", "ALEYA TEKSTİL SANAYİ VE TİCARET A.Ş.", "ANL GIDA VE TEM MAD.MAK.SAN.LTD.ŞTİ.",
            "ANNAÇLAR GIDA VE TEMİZLİK MAD.MAK.SAN.TİC.LTD.ŞTİ.", "ARASAN TEKSTİL SAN.TİC.LTD.ŞTİ.", "ARDA İPLİK TEKSTİL SAN. VE TİC. LTD. ŞTİ.",
            "ARMO GIDA MAK.TEKS.TİC.LTD.ŞTİ.", "ARSOR TEKSTİL SAN.DIŞ.TİC.LTD.ŞTİ.", "ASCAN TEKSTİL SAN.TİC.A.Ş.",
            "ASKAR MAKİNE SANAYİ TİCARET A.Ş.", "ASSAHRA MAK.GERİ DÖN.PLAS.OTO YAN.SAN.TİC.LTD.ŞTİ", "ASSAN HANİL OTO. SAN. VE TİC. A.Ş.",
            "ATADAN TEKSTİL SAN.TİC.A.Ş.", "ATALAR TEKSTİL VE GIDA MAD.SAN.TİC.LTD.ŞTİ.", "AUNDE TEKNİK TEKSTİL A.Ş.",
            "AYCEN TEKS.SAN.TİC.LTD.ŞTİ.", "AYKON TEKSTİL SAN.TİC.LTD.ŞTİ.", "AYMİNA DEK.TAS.TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "AYPA TEKSTİL GIDA SAN. VE TİC. LTD. ŞTİ.", "AYPAŞ FANTAZİ İPLİK.SAN.TİC.LTD.ŞTİ.", "AYTÜRK BOYA SAN.TİC.LTD.ŞTİ.",
            "B-PLAS BURSA PLASTİK İNŞAAT VE TURİZM SAN.A.Ş", "B.T.E. EV TEKSTİL ÜRÜNLERİ SAN. VE TİC. LTD. ŞTİ.",
            "BA-SE KAUÇUK SAN.VE TİC. A.Ş.", "BAHATEKS TEKS.SAN.TİC.LTD.ŞTİ.", "BARMA DIŞ TİC.A.Ş.", "BARUTÇU TEKSTİL SAN.TİC.TLD.ŞTİ.",
            "BATI CILIK SAN.TİC.A.Ş.", "BCS BURSA CEKET SAN.TİC.LTD.ŞTİ.", "BENAŞ TEKSTİL SAN.TİC.LTD.ŞTİ.BERKAY UNLU MAMÜLLER GIDA SA.VE TİC.LTD.ŞTİ",
            "BERRU TEKSTİL SAN.TİC.LTD.ŞTİ.", "BERTEKS TEKSTİL SAN.TİC.A.Ş.", "BEYÇELİK GESTAMP TEKNOLOJİ VE KALIP SANAYİ A.Ş.",
            "BEZTAŞ TEKSTİL TİC.SAN.LTD.ŞTİ.", "BHS HAŞIL VE TEKSTİL ÜR. TİC. VE SAN. A.Ş.", "BİKSAN BURSA İPLİK VE KUMAŞ SANAYİ VE TİCARET LİMİTED ŞİRKETİ",
            "BİL-HAN TEKSTİL SAN. VE TİC. A.Ş.", "BİLAÇLILAR TEKSTİL SAN.TİC.AŞ.", "BİREL TEKSTİL SANAYİ VE TİCARET LTD.ŞTİ.",
            "BPO B-PLAS PLASTİC OMNİUM OTO. PLASTİK VE METAL YAN SAN. A.Ş.", "BULDAĞ TEKSTİL A.Ş.",
            "BURFLEKS POLİÜRETAN PARÇA GELİŞTİRME SAN. VE TİC. LTD.ŞTİ.", "BURSA ALFA KİMYA SAN. VE TİC. A.Ş.", "BURSA AVİZE SANAYİ",
            "BURSA SAFRAN YEMEK ÜRETİM HİZ. A.Ş.", "BURSALI DIŞ TİCARET A.Ş.", "BURSALI TEKSTİL SANAYİ VE TİCARET",
            "BURTEKS BOYA APRE TEKS.SAN.LTD.ŞTİ.", "BÜROSİT BÜRO DONANIMLARI SAN. VE TİC.AŞ", "C.E.R.M TEKSTİL TİCARET VE SANAYİ LTD.ŞTİ.",
            "CANPA EV TEKSTİL SAN.VE TİC.LTD.ŞTİ.", "CEGİ TEKSTİL KONFEKSİYON SAN. VE TİC.LTD.ŞTİ.", "CEMETA TEKSTİL SAN. TİC. LTD. ŞTİ.",
            "CHASSİS BRAKES iNTERNATİONAL OTOMOTİV SANAYİ VE TİCARET ANONİM ŞİRKETİ", "CUNATEKS TEKS.SAN.TİC.LTD.ŞTİ.", "ÇA-KAR TEKSTİL SAN.AŞ.",
            "ÇAĞNAR TEKSTİL SAN.TİC.LTD.ŞTİ", "ÇAHAN DİJİTAL BASKI SAN.TİC.A.Ş.", "ÇAHAN TEKSTİL SAN.TİC.AŞ.", "ÇATEKS İÇ VE DIŞ TİC.SAN.LTD.ŞTİ.",
            "ÇEÇEN TEKSTİL SAN.TİC.AŞ.", "ÇETİN ŞENAY-BURKANLAR TEKSTİL", "ÇEVİKEL TEKSTİL TİC.SAN.LTD.ŞTİ", "ÇİLEK MENSUCAT İPLİK TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "ÇİZAŞ ÇELİK VE ZİNCİR SAN.TİC.AŞ.", "D.E.B.Y TEKSTİL SAN.TİC.A.Ş.", "DE-RA KONFEKSİYON İPLİK TEKSTİL LTD. ŞTİ", "DE-Tİ TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "DEĞİRMENCİOĞLU ÇEK-YAT SAN. VE TİC. LTD.ŞTİ.", "DEMKAY TEKS.SAN.LTD.ŞTİ.", "DENPA METAL SAN.LTD.ŞTİ.", "DERGİOĞULLARI YANG.SÖN.SAN. TİC.LTD.ŞTİ.",
            "DERİNŞAH TEKSTİL SAN.TİC.LTD.ŞTİ.", "DİKİCİ TEKSTİL SAN.TİC.LTD.ŞTİ.", "DİLEK TEKS.SAN.TİC.LTD.ŞTİ.", "DİLHAN TEKSTİL SAN.TİC.A.Ş.",
            "DMR DİJİTAL KUMAŞ BASKI İPLİK KONFEKSİYON SAN.TİC. LTD. ŞTİ.", "E.N.A. TEKSTİL TİC.SAN.AŞ.", "E.S.C TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "EBUTEKS KİM.MAD.SAN.TİC.LTD.ŞTİ.", "EGESİM İPLİK KONFEKSİYON SAN. VE TİC. LTD. ŞTİ.", "EKART TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "ELATEK KAUÇUK PLASTİK VE KİM.MAD.SAN.TİC.LTD.ŞTİ.", "ELE-NOR TEKSTİL KONF.REKLAM GIDA TURİZM LTD.ŞTİ.", "ELEGANT TEKSTİL SAN. VE TİC. LTD. ŞTİ.",
            "ELEMENT TEKSTİL TURİZM TİC.SAN.LTD.ŞTİ.", "ELLA DİZAYN BRODE SAN. VE TİC. LTD. ŞTİ.", "ELTEKS TEKSTİL VE KİMYA ÜRÜN.SAN.İÇ VE DIŞ TİC.LTD.ŞTİ.",
            "EMİRALİ TEKSTİL KONFEKSİYON AŞ", "EMKO ELEKTRONİK SANAYİ VE TİCARET AŞ.", "ENFAL TEKSTİL MAK.SAN.TİC.LTD.ŞTİ.", "ENSTİTÜ İPLİK TEKSTİL ÜRÜN. SAN.VE TİC.LTD.ŞTİ.",
            "EPİRİLER TEKSTİL SAN.TİC.AŞ.", "EPSAN PLASTİK SAN.TİC.LTD.ŞTİ.", "ER GIDA SANAYİ TİCARET .A.Ş.", "ERÇELİK MOBİLYA VE GEREÇLERİ TİC. SAN. A.Ş.",
            "ERDEM TEKSTİL SAN VE TİC.A.Ş.", "ERKALIP KALIP MAK.SAN.TİC.A.Ş.", "ERKAŞ ÇÖZGÜ-BURAK DİNDAR", "ERKURT TEKSTİL VE YALITIM ÜRÜN. SAN. VE TİC. A.Ş.",
            "ERMETAL OTOMOTİV VE EŞYA SAN.TİC.A.Ş.", "ESGİN TEKSTİL SAN.TİC.LTD.ŞTİ.", "ETA YEDAK PARÇA VE KAUÇUK İMLT. VE TİC.LTD.ŞTİ.", "EVİMTEKS TEKSTİL İNŞAAT TURİZM SAN.TİC.AŞ.",
            "EVİNOKS SERVİS EKİPMANLARI A.Ş.", "EVİRGEN ÖRME", "EYŞANMOB YATAK MOB.TEKSTİL SAN.TİC.LTD.ŞTİ.", "F.B.N. TEKSTİL İTH. İHR. PAZ. SAN. VE TİC. LTD.ŞTİ.",
            "F.S.S FREN SİSTEMLERİ SANAYİ", "FEMTEKS TEKSTİL TURİZM SAN.TİC.LTD.ŞTİ.", "FERSAM TEKSTİL SAN.TİC.LTD.ŞTİ.", "FİBER İPLİK MENSUCAT SAN.TİC.A.Ş",
            "FİCE TEKSTİL SAN.TİC.LTD.ŞTİ.", "FİSTAŞ FANTAZİ İPLİK SAN.TİC.A.Ş", "FLOTEKS PLASTİK SAN.TİC.AŞ.", "GESA  ÖRME TEKS.SAN. VE TİC. A.Ş.",
            "GHS TEKSTİL SAN.TİC.A.Ş.", "GİDAŞ İNŞAAT TAAHHÜT SAN.TİC.AŞ.", "GİPECİLER TEKS.SAN.TİC. A.Ş.", "GİPTAŞ İPLİK SAN. TİC. A.Ş.",
            "GÖKSEL TEKSTİL KONFEKSİYON İNŞ. OTO. GIDA SAN. VE TİC. LTD. ŞTİ.", "GÖKSİM İPLİK TEKSTİL KONFEKSİYON SAN. VE TİC. LTD. ŞTİ.", "GÖZDELER OTOMOTİV",
            "GRAMMER KOLTUK SİSTEMLERİ SAN.TİC.AŞ.", "GRUP TEKSTİL SAN.VE TİC.A.Ş.", "GÜL TEKSTİL  VE BOYA-APRE SAN.TİC.A.Ş.", "GÜLEÇSOY TURİZM TEKSTİL PAZ. SAN. VE TİC. LTD. ŞTİ.",
            "GÜLESER TEKSTİL SAN.VE TİC.LTD.ŞTİ.", "GÜLİNAN TEKSTİL SAN.TİC.LTD.ŞTİ.", "GÜNGÖRLER TEKSTİL SAN. VE TİC. LTD. ŞTİ.",
            "GÜNİPEK TEKSTİL SANAYİ VE TİCARET LTD.ŞTİ.", "GÜRÇETİN TEKSTİL SANAYİ TİCARET A.Ş.", "GÜRTEKİN TEKSTİL KUMAŞ İNŞAAT TAAHHÜT SAN. VE TİC. LTD.ŞTİ.",
            "H.M.Y. TEKSTİL TURİZM SAN.TİC.LTD.ŞTİ", "HAGE TEKSTİL SAN.TİC.A.Ş.", "HANDE TEKSTİL GIDA SAN.TİC.LTD.ŞTİ.", "HARPUT TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "HASSAS PLASTİK MAK.AHŞ.LTD.ŞTİ.", "HİBAŞ TEKSTİL ÇÖZGÜ SANAYİ Sanayi", "HÜNER KRİKO YEDEK PARÇA SAN. TİC. LTD.ŞTİ.", "IHLAMUR TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "ISI-ŞAH END. REZİS.VE ISI EKİP. SAN. VE TİC. A.Ş.", "ISRINGHAUSEN KOLTUK SİSTEMLERİ A.Ş.", "IŞIKSER TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "IŞIKSOY TEKS.SAN.TİC.LTD.ŞTİ.", "İBAŞ TEKSTİL GIDA SAN.TİC.A.Ş.", "İÇDAŞ ÇELİK ENERJİ TERSANE VE ULAŞIM SAN A.Ş.", "İLKETAP ETİKET VE AMBALAJ SAN.TİC.AŞ.",
            "İLKO TEKSTİL SANAYİ VE TİCARET LTD. ŞTİ.", "İNKİŞAF DEMİRTAŞ TEKS.SAN.A.Ş.", "İPEKİŞ MENSUCAT TÜRK A.Ş.", "İPEKS TEKS.SAN.TİC.LTD.ŞTİ.",
            "İPTAŞ TEKSTİL SA.TİC.A.Ş.", "İSOTEKS TEKS. İTH.İHR.SAN.TİC.LTD.ŞTİ.", "İZGÜN GIDA TURİZM TAŞIMACILIK TEMİZLİK GÜVENLİK ve MOBİLYA SAN. TİC. A.Ş.",
            "JADİDTEX TEKSTİL SANAYİ VE TİCARET LTD. ŞTİ.", "K.P.S. KAUÇUK PARÇA SANAYİ VE TİCARET LİMİTED ŞİRKETİ", "KADİM KADİFE  TEKSTİL SAN. VE TİC. LTD. ŞTİ.",
            "KAFKA İPLİK BÜKÜM TEKSTİL SA. VE TİC.LTD.ŞTİ.", "KALE TEKSTİL SAN.VETİC.AŞ.", "KAMSAN METAL ELK.MAK.SAN.TİC.LTD.ŞTİ.", "KAPİMSAN OTO SAN.TİC.LTD.ŞTİ.",
            "KAPLANLAR SOĞUTMA SAN.TİC.AŞ.", "KIRAYTEKS TEKSTİL SAN.TİC.LTD.ŞTİ.", "KOLTUKSAN OTOMOTİV SAN.TİC.A.Ş.", "KOTONTEKS TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "KOZA TEKSTİL SAN.DIŞ.TİC.LTD.ŞTİ.", "KULÜP TEKNİK KUMAŞÇILIK SAN. VE TİC. A.Ş.", "KURTSAN PAS.ÇELİK END.MAK.VE TES.İTH.İHR.TİC.SAN.LTD.ŞTİ.",
            "KURUOĞLU TURİZM TEKSTİL SAN.TİC.AŞ.", "KUZAY PLASTİK", "KUZEY ÇÖZGÜ HAŞIL  SAN. VE TİC. LTD. ŞTİ.", "KUZUALTI TEKSTİL VE GIDA SAN.TİC.A.Ş.",
            "KÜÇÜKERLER TEKSTİL TİC.SAN.LTD.ŞTİ.", "KÜTAHYA PORSELEN A.Ş.", "LEN-ZA TEKSTİL SAN. VE TİC. LTD. ŞTİ",
            "LOTTEKS TEKS.İNŞ.LTD.ŞTİ.", "LOW PROFİLE İSTANBUL SAN.VE DIŞ TİC.A.Ş", "M.EMİN TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "M.İ.B TEKSTİL SANAYİ VE TİCARET A.Ş.", "MAÇİN TEKSTİL OTO SAN.LTD.ŞTİ.", "MAİTÜRK KİMYA SANAYİ VE TİCARET LTD.ŞTİ.",
            "MAKRO KUMAŞÇILIK KONF. TEKS. LTD. ŞTİ.", "MARSTEKS DÖŞEMELİK KUMAŞ  TEKSTİL KONF.SAN.TİC.LTD.ŞTİ.",
            "MASGTEKS TEKSTİL SAN. TİC. LTD. ŞTİ.", "MAYFİL TEKS.SAN.TİC.LTD.ŞTİ.", "ME-PAR NAKLİYAT TİC. A.Ş.",
            "MEDOKS TEKSTİL TASARIM MAKİNA SAN. VE TİC. LTD. ŞTİ.", "MEGREL TEKSTİL SAN.TİC.LTD.ŞTİ.", "MEHMET YEŞİL VE ORTAKLARI",
            "MERDİVEN TEKSTİL İTH. İHR. SAN. TİC. LTD. ŞTİ.", "MERTCAN KADAYIFCILIK TATLICIK UNLU MAM. SAN. LTD. ŞTİ.", "MESAFE TEKSTİL",
            "MESCAN TEKSTİL SANAYİ VE TİCARET LTD. ŞTİ.", "METESAN TEKSTİL SANAYİ VE DIŞ TİC. LTD. ŞTİ.",
            "METKON ENDÜSTRİYEL CİHAZ SAN. TİC. A.Ş.", "METROMAT MATBAACILIK TEKS.SAN.LTD.ŞTİ.", "MEYTEKS  İPİLİK TEKSTİL SAN.TİC.LTD.ŞTİ.",
            "MİLANGAZ LPG DAĞ.SAN.TİC.A.Ş.LPG", "MOBSİT MOB.SAN.TİC.LTD.ŞTİ.", "MODESİM TEKSTİL SAN.TİC.AŞ.", "MORAL TEKSTİL SAN.TİC.AŞ.",
            "MOTİF MENSUCAT SAN.TİC.LTD.ŞTİ.", "MUZAFFER MERT TEKSTİL SAN. VE TİC. LTD. ŞTİ.", "NAİL SARI-SARI ANKOLAJ SANAYİ",
            "NAR BRODE SANAYİ VE TİCARET A.Ş.", "NARA TEKSTİL SAN.TİC.AŞ.", "NASIRLAR YAPI TEKSTİL SAN. VE TİC.LTD.ŞTİ.",
            "NAYSA PLASTİK SAN. VE TİC. LTD. ŞTİ.", "NBS YEDEK PARÇA SAN.TİC.", "NECATİ AKDENİZ SORGENTE TEKSTİL LTD.ŞTİ.",
            "NEO PLAS LEVHA ÜRETİM SİSTEMLERİ LTD.ŞTİ.", "NETLOG LOJİSTİK HİZMETLERİ A.Ş.", "NİHAT BURSALI TEKSTİL SAN.TİC.AŞ.",
            "NİL-SAN TEKSTİL SANAYİ TİCARET LTD. ŞTİ.", "NOPE TEKSTİL SAN.VE TİC.LTD.ŞTİ.", "NUREL MEDİKAL SAN.TİC.A.Ş.",
            "NUREL TEKSTİL APRE VE BOYA SAN.TİC.A.Ş.", "NURSULTAN TEKS.SAN.TİC.LTD.ŞTİ.", "NY HİSAR TEKSTİL BOYA SAN. VE TİC. A.Ş.",
            "OBAKUR GIDA İNŞAAT TURİZM SAN. VE TİC. A.Ş.", "OK AMBALAJ PLASTİK SAN. VE TİC. LTD. ŞTİ.", "OKYAY ÖRME BOYA APRE SAN. TİC. LTD. ŞTİ.",
            "OKYAY TEKSTİL VE ÖRME SAN.TİC.AŞ.", "OMSA OTOMOTİV AKSESUARLARI SAN. TİC. A.Ş.", "OMTEC OTOMOTİV MOBİLYA SAN.VE TİC.A.Ş.",
            "OMYAP OTOMOTİV MAKİNE İNŞAAT SAN. VE TİC. A.Ş.", "OMYAP TURİZM EMLAK İNŞ.VE TİC.LTD.ŞTİ.", "ON EM DÖŞEMELİK KUMAŞ SANAYİ A.Ş.",
            "ORVEN KAUÇUK MAK.SAN.TİC.LTD.ŞTİ.", "OZAN BOYA VE KİMYEVİ MaddELER TARIM İNŞAAT SAN. VE TİC. A.Ş.", "ÖR-İŞ FANTAZİ İPLİK TEKSTİL SAN. VE TİC. LTD. ŞTİ.",
            "ÖZ-ÜÇEL TEKSTİL SAN.TİC.LTD.ŞTİ.", "ÖZÇİMEN TEKSTİL SAN.TİC.LTD.ŞTİ.", "ÖZHÜNER GIDA SAN.TİC.LTD.ŞTİ.",
            "ÖZKONYALI TEKSTİL SAN. TİC.LTD.ŞTİ.", "ÖZRENK MENSUCAT SAN.TİC.LTD.ŞTİ.", "ÖZTEKSTİL SAN.TİC.LTD.ŞTİ.",
            "ÖZÜER PETROL ÜRÜNLERİ LTD.ŞTİ.", "ÖZZÜMRÜT İŞ ELBİSELERİ SAN. VE TİC. A.Ş.", "P.M.S.ALÜMİNYUM SANAYİ VE TİC.LTD.ŞTİ.",
            "PAKPLAS PLASTİK TEKSTİL SAN.VE TİC.LTD.ŞTİ.", "PARLAMIŞ BOYA İPLİK TEKSTİL SAN.TİC. A.Ş.", "PARLAMIŞ TEKS.SAN. VE TİC. A.Ş.",
            "PAS OTOMOTİV YEDEK PARÇA SAN.TİC.LTD.ŞTİ.", "PE-GA OTOMOTİV SÜSPANSİYON SAN .VE TİC.A.Ş.", "PEHLİVANSOY TEKSTİL KONF.SAN.TİC.AŞ.",
            "PERDEMO TEKS.DOK.SAN.LTD.ŞTİ.", "PLASMOT MOBİLYA VE OTOMOTİV PLASTİKLERİ", "PLİSTAR PLİSE VE KONFEKSİYON SAN.TİC.",
            "PMS METAL PROFİL ALÜMİNYUM SAN.TİC.AŞ.", "POLYTEKS TEKSTİL SAN.ARAŞTIRMA VE EĞİTİM AŞ.", "PRESTİGE MENSUCAT.SAN.TİC.A.Ş.",
            "PRO-KAP LASTİK KAPLAMA LOJ. OTOM. SAN. VE TİC. A.Ş.", "PRO-LAST PROFİL LASTİK SANAYİ TİCARET LTD ŞTİ", "PROMAKS TEKSTİL KONF.SAN.TİC.LTD.ŞTİ.",
            "PRUSA PAZARLAMA LTD.ŞTİ.", "PRUSA TEKSTİL LTD.ŞTİ.", "RASADE TEKSTİL SANAYİ VE TİCARET LTD. ŞTİ.", "REBİ TEKSTİL SAN.TİC.LTD.ŞTİ.", "REVAR OTOMOTİV SANAYİ VE TİCARET A.Ş.", "RÜYA PİKE LTD.ŞTİ.", "S.D.B. TEKSTİL SANAYİ VE TİC. LTD. ŞTİ.", "S.İ.S. SAYILGAN İPLİK TEKSTİL TURİZM İNŞAAT SANAYİ VE TİC.A.Ş.", "S.Y.K. TEKSTİL SANAYİ TİCARET AŞ.", "SAFAŞ TEKSTİL SAN.TİC.LTD.ŞTİ.", "SAİT NALBUR TEKSTİL SAN.VE TİC LTD.ŞTİ.", "SATEKS TEKSTİL SAN.TİC.LTD.ŞTİ.", "SAVRANOĞULLARI TEKSTİL SAN.TİC.LTD.ŞTİ.", "SAYMIN ÖMÜRLÜOĞLU SAN.TİC.A.Ş.", "SCHOLZ METAL NAKLİYE GERİ DÖNÜŞÜM SANAYİ VE TİCARET LİMİTED ŞİRKETİ", "SCHWEGLER SOLİD CARBİDE TOOLS MAKİNA TAKIM SAN.TİC.LTD.ŞTİ.", "SEÇEN TEKSTİL SAN.VE TİC.LTD.ŞTİ.", "SEGER SES VE ELEKTRİKLİ GEREÇLER SANAYİ AŞ.", "SELBİ TEKSTİL SAN.TİC.LTD.ŞTİ.", "SELİNAY MODA TASARIM TEKSTİL SAN.TİC. LTD. ŞTİ.", "SELVİOĞLU TEKSTİL SAN.VE TİC. LTD.ŞTİ.", "SEMİRAMİS TEKSTİL GIDA TURİZM SAN. VE TİC. LTD. ŞTİ.", "SERASER TEKSTİL SAN. TİC. LTD. ŞTİ.", "SERAY TEKSTİL SAN.VE TİC.LTD.ŞTİ.", "SERTEKS İPLİK SANAYİ VE TİCARET LTD. ŞTİ.", "SİMSİYAH TEKSTİL TURİZM SAN. TİC.LTD. ŞTİ.", "SİMYE TEKSTİL KONFEKSİYON SAN.TİC.LTD.ŞTİ.", "SİNTERAMA-TAŞDELEN TEKSTİL SANTİC.AŞ.", "SMD TEKSTİL SANAYİ VE TİC. LTD. ŞTİ.", "SOFRA YEMEK ÜRT.HİZ.A.Ş.", "SONAR OTOMOTİV SAN.TİC.LTD.ŞTİ.", "SONASYA KUMAŞ SANAYİ VE TİCARET LD. ŞTİ.", "SÖKÜCÜLER TEKSTİL SAN.TİC.AŞ.", "SÖNMEZ ASF İPLİK  VE BOYA SAN.TİC.A.Ş.", "SÖNMEZ FLAMENT SENT. İPLİK VE ELYAF SAN.A.Ş.", "SÖNMEZ PAMUKLU SAN.TİC.A.Ş.", "SÖZTEKS TEKSTİL SAN.TİC.LTD.ŞTİ.", "SPİRMAK MAKİNA SAN.TİC.LTD.ŞTİ.", "SUNTEKS  BOYA SAN.A.Ş.", "ŞAHİNKUL MAKİNA VE YEDEK PARÇA SAN.TİC.AŞ.", "ŞARMEN KARACA TEKSTİL SAN. VE TİC. LTD.ŞTİ.", "ŞELALE KARTELA DİZAYN ", "ŞEM LASTİK SAN.VE TİC. A.Ş.", "ŞEMSAC MAKİNE SAN. ve TİC. LTD. ŞTİ.", "ŞİŞTEKS-HÜSEYİN ŞİŞKOOĞLU", "ŞRK OTOMOTİV YAN.SAN.TİC.A.Ş.", "TARKAN YAMAN-YAMAN MENSUCAT", "TAYSAN OTO YAN SANAYİ VE TİCARET A.Ş.", "TEKNİK GÜÇ İNŞAAT SAN.TİC.LTD.ŞTİ.", "TEKNİK MALZEME TİC.VE SAN.A.Ş.", "TEKNOKAST ALÜMİNYUM ENJEKSİYON VE DÖKÜM SAN. TİC. LTD. ŞTİ.", "TEKSİUM TEKSTİL ÜRÜNLERİ SAN.TİC.LTD.ŞTİ", "TERCİH NAKLİYAT AKAR. TEKS. İNŞ.PETR.TUR. SAN. TİC. A.Ş.", "TERMOTEKS TEKSTİL SAN.TİC.LTD.ŞTİ.", "TEZYAPARLAR TEKSTİL SAN.TİC.LTD.ŞTİ.", "TİBERİNA OTOM.SAN.TİC.LTD.ŞTİ.", "TİNES TEKSTİL İTHALAT İHRACAT SAN. VE TİC. LTD. ŞTİ.", "TOFAŞ TÜRK OTOMOBİL FABRİKASI AŞ.", "TOPÇESAN TOPBAŞ ÇELİK SAN.TİC.AŞ.", "TREND TEKSTİL SAN.TİC.AŞ.", "TRUVA GİYİM SAN. VE TİC. A.Ş.", "TURKUAZ TEKSTİL DIŞ TİCARET LİMİTED ŞİRKETİ", "TÜRKSEVEN TEKSTİL SAN.TİC.LTD.ŞTİ.", "ULUDAĞ HALK EKMEK UNLU MAMULLERİ LTD.ŞTİ.", "UPC,UZAY YÜZEY İŞLEM LTD.ŞTİ.", "USK TEKSTİL.SAN.TİC.LTD.ŞTİ.", "USTA GRUP TEKSTİL SAN. VE TİC. LTD. ŞTİ.", "ÜNAŞ TEKSTİL SAN.VE TİÇ. A.Ş", "ÜNİ-TEKS TEKSTİL SANAYİ VE TİCARET LTD.ŞTİ.", "ÜNSPED PAKET SERVİSİ SAN.TİC.A.Ş.", "VALEO OTOMOTİV SİSTEMLERİ ENDÜSTRİSİ AŞ.", "VEMTEKS DOK.SAN.TİC.LTD.ŞTİ.", "VİNO KADİFE TEKSTİL SAN.TİC.LTD.ŞTİ.", "WOSTECH OTOMOTİV SAN. VE TİC. A.Ş.", "Y.K.S. TEKS.SAN.VE TİC.A.Ş.", "YAMER TEKS.SAN.TİC.LTD.ŞTİ.", "YAŞALAR KALIP YEDEK PARÇA SAN.LTD.ŞTİ.", "YEDİKARDEŞ TEKSTİL SAN.TİC.A.Ş.", "YENİ AS METAL ROT VE ROTİL SAN.TİC.LTD.ŞTİ.", "YENİ FORM METAL EŞYA SAN.TİC.A.Ş.", "YILMAM TEKSTİL SAN.LTD.ŞTİ.", "YILMAR ÇELİK TEL.YAY.SAN.TİC.LTD.ŞTİ.", "YILMAZ SÜNGER KUMAŞ DÖŞ.MALZ.SAN. VE TİC.LTD.ŞTİ.", "YILMAZ-TEKS TEKSTİL SAN.TİC.ŞTİ.", "YILSAY TEKSTİL SAN.TİC.LTD.ŞTİ.", "YİĞİTOĞLU KİMYA A.Ş.", "YUTEKS TEKSTİL SAN.TİC.LTD.ŞTİ.", "YÜCEL MENSUCAT SAN.VE TİC. LDT. ŞTİ.", "ZEKİ DİLEK TEKSTİL TİCARE VE SANAYİ LTD. ŞTİ.", "ZEKİNE KILIÇ MODA İP TEKSTİL SAN. VE TİC. A.Ş.", "ZENO DİJİTAL BASKI KUMAŞ TEKSTİL SAN. VE TİC. LTD. ŞTİ.", "ZEYDE STOR PERDE SİS. TEKS. SAN. TİC. LTD. ŞTİ.", "ZİMAŞ ZİNCİR VE MAKİNE SAN.TİC.AŞ."
        ];

        $this->StreetNames = ["19 MAYIS SK", "23 NİSAN SK", "29 EKİM SK", "30 AĞUSTOS SK", "8 DİREKLİ HAMAM SK",
            "ABDULLAH SK", "ACAR SK", "ACIBADEM SK", "ACISU SK", "ADA SK", "ADALET CD", "ADATEPE SK", "ADEM SK",
            "ADIM SK", "ADRES SK", "AFFAN KİTAPÇIOĞLU CD", "AHMET CAN BALİ SK", "AHMET SK", "AHMET SUAT ÖZYAZICI CD",
            "AHSEN SK", "AKAR SK", "AKARSU SK", "AKASYA SK", "AKAY CD", "AKDENİZ SK", "AKER SK", "AKIM SK", "AKIN SK",
            "AKMEŞE SK", "AKSU SK", "AKTUĞ SK", "AKTÜRK SK", "AKTİF SK", "AKÇAY SK", "AKİF SARUHAN CD", "ALACA SK",
            "ALACAHAMAM SK", "ALACAHAN SK", "ALAYBEY SK", "ALAYOĞLU SK", "ALDIKAÇTI SK", "ALDIKAÇTI ÇIKMAZ SK",
            "ALEMDAR SK", "ALINTERİ SK", "ALIÇ SK", "ALPER SK", "ALTIN SK", "ALTINTAŞ SK", "ALTINTEPE SK", "ALTINŞEHİR CD",
            "ALİ ASLAN SK", "ALİ NACİ PEKER CD", "ALİ NAKİ EFENDİ SK", "ALİ SK", "ALİ ÇIKMAZI SK", "ALİBEY SK", "ALİCAN SK", "ALİM SK",
            "ALİOĞLU SK", "ALİPAŞA SK", "AMASYA CAMİİ ARALIĞI SK", "AMASYA CAMİİ SK", "ANADOLU BLANIT SK", "ARALIK SK", "ARDIÇ SK",
            "ARI SK", "ARKA SK", "ARKADAŞ SK", "ARMAĞAN SK", "ARPA SK", "ARZU SK", "ARİF SK", "ASALET SK", "ASIRLIK SK", "ASLAN KALINTAŞ SK",
            "ASMALI SK", "ASUDE SK", "ATA CD", "ATAK SK", "ATATÜRK ALANIATEŞBÖCEĞİ SK", "ATILGAN SK", "ATILIM SK", "ATLAS SK", "ATMACA SK",
            "ATİLLA SAĞLAM SK", "AVCI SK", "AY SK", "AYAKKABICILAR SİTESİ SK", "AYASOFYA CD", "AYDIN SK", "AYDINLAR SK", "AYDINLAR ÇIKMAZI SK",
            "AYDINTEPE SK", "AYDOĞDU SK", "AYIŞIĞI SK", "AYVALI SK", "AYÇİÇEĞİ SK", "AYŞE HATUN SK", "AZİZ SK", "AÇELYA SK", "AĞAÇ SK",
            "AŞÇILAR SK", "AŞİKAR SK", "BABAYİĞİT SK", "BADEM SK", "BAHADIR SK", "BAHAR SK", "BAHARDALI SK", "BAHÇE SK", "BAHÇECİK CAMİİ SK",
            "BAHÇELİ SK", "BAHÇIVANCI SK", "BAK SK", "BAKANER SK", "BAKKAL ÇIKMAZI SK", "BALABAN SK", "BALIK SK", "BALIKLI SK",
            "BALIKPAZARI SK", "BALIKYAĞI FABRİKA SK", "BALIKÇILAR SK", "BALKAYA SK", "BALLICA SK", "BALOĞLU SK", "BALÖZÜ SK",
            "BANKA ÇIKMAZI SK", "BARBOROS CD", "BARINAK SK", "BARIŞ CD", "BARIŞ SK", "BARUTÇUOĞLU SK", "BASAMAK SK", "BASIN SİTESİ SK",
            "BAYINDIR CD", "BAYIR SK", "BAYRAK SK", "BAYRAKTAR SK", "BAYRAM SK", "BAYRAMBEY SK", "BAĞIMSIZ SK", "BAĞLARBAŞI SK",
            "BAŞAK SK", "BAŞAR SK", "BAŞKAYA SK", "BAŞKENT SK", "BEBEK SK", "BEDESTAN CD", "BEKAROĞLU SK", "BEKTAŞ SK",
            "BEKÇİ ALİ SK", "BELDE SK", "BEREKET SK", "BESTE SK", "BEYAZGÜL SK", "BEŞEVLER SK", "BEŞİKÇİ SK", "BILDIRCIN SK",
            "BOLLUK SK", "BORA SK", "BORSA SK", "BOSTAN SK", "BOTANİK SK", "BOYLAM SK", "BOZTEPE CD", "BOZTEPE KAHYAOĞLU SK",
            "BOZTEPE ÇAMLIK SK", "BUDAK SK", "BUHAR SK", "BULUT SK", "BULUŞ SK", "BURCU SK", "BURLA HATUN CD", "BURÇ SK",
            "BUZLUDERE CD", "BUĞDAY SK", "BÜKLÜM SK", "BÜKRÜOĞLU SK", "BÜLBÜL SK", "BÜŞRA SK", "BİLALOĞLU SK", "BİLGE SK",
            "BİLGİ SK", "BİLLUR SK", "BİLİM SK", "BİRLİK SK", "BİTKİ SK", "BİÇİM SK", "CAMİ ALTI SK", "CAMİ ARALIĞI SK",
            "CAMİ KARŞISI SK", "CAMİ SK", "CAMİLİ SK", "CAN SK", "CANAN SK", "CANDAN SK", "CEFA SK", "CELEP SK", "CEMRE SK",
            "CEMİL USTA CD", "CEMİYET SK", "CENK SK", "CENNET SK", "CENNETKUŞU SK", "CEPHANELİK SK", "CESUR SK", "CEVAHİR SK",
            "CEVHER SK", "CEVİZ SK", "CEYHAN SK", "CEYLAN SK", "COŞANDERE SK", "COŞKU SK", "COŞKUNDERE CD", "COŞKUNLAR SK",
            "CUDİBEY MEKTEP SK", "CUMA CD", "CUMHURİYET CD", "CÜMLE SK", "CİHANGİR SK", "CİVELEK SK", "ÇABUK SK", "ÇAKIR SK",
            "ÇAKMAKÇILAR SK", "ÇALIK SK", "ÇALIKUŞU SK", "ÇALIŞKAN SK", "ÇAMLIBEL SK", "ÇAMLICA CD", "ÇAMLIK CD", "ÇAMLIK CİVARI SK",
            "ÇAMLIK6 SK", "ÇAMLIÇEŞME SK", "ÇAMOBA CD", "ÇARDAK SK", "ÇARŞI ARALIĞI SK", "ÇARŞI CAMİİ SK", "ÇAVUŞOĞLU SK",
            "ÇAYIR SK", "ÇAĞDAŞ SK", "ÇAĞLA SK", "ÇAĞLAYAN SK", "ÇELEBİ SK", "ÇELİK SK", "ÇELİKTEPE SK", "ÇEMBER SK", "ÇEVRE SK",
            "ÇEŞME SK", "ÇEŞMEALTI SK", "ÇEŞMELİ SK", "ÇINAR SK", "ÇINARLI SK", "ÇIRAKOĞLU SK", "ÇOBAN YILDIZI SK", "ÇOBANKIZI SK",
            "ÇUBUKÇULAR SK", "ÇUKURHAMAM SK", "ÇUKURÇAYIR YOLU CD", "ÇÖMLEKÇİ CD", "ÇÖMLEKÇİ MEKTEP SK", "ÇİFTE HAMAM SK", "ÇİLE SK",
            "ÇİLİNGİROĞLU SK", "ÇİMEN SK", "ÇİNİLİ SK", "ÇİZMECİOĞLU SK", "ÇİÇEK SK", "ÇİÇEKLİ SK", "ÇİĞDEM SK", "DAMLA SK", "DAYIOĞLU SK",
            "DEDEOĞLU SK", "DEFNE SK", "DEKOR SK", "DEMET SK", "DEMOKRASİ SK", "DEMİR SK", "DEMİRCİLER SK", "DEMİRKAPI SK", "DENİZ SK",
            "DENİZCİLER SK", "DENİZGÜLÜ SK", "DENİZHAN SK", "DENİZKIZI SK", "DERE SK", "DEREBOYU SK", "DERELİ SK", "DEREOTU SK",
            "DEREÜSTÜ SK", "DEREİÇİ SK", "DERGAH SK", "DERMAN SK", "DERVİŞOĞLU SK", "DERVİŞOĞLU ÇIKMAZI SK", "DERVİŞPAŞA SK",
            "DERYA CD", "DESEN SK", "DESTAN SK", "DETAY SK", "DEVA SK", "DEVLET KARAYOLU CD", "DEVLET SAHİL YOLU CD", "DEVRAN SK",
            "DEĞER SK", "DEĞERLİ SK", "DEĞİRMEN CD", "DEĞİRMENCİ SK", "DEĞİRMENDERE CD", "DEĞİRMENDERE ÇARŞI SK", "DEĞİŞİM SK",
            "DOKTOR CEMAL TURFAN SK", "DOKTOR CEMİL BULAK SK", "DOKTOR SÜREYYA SK", "DOKTOR İBRAHİM OKMAN CD", "DOKUMACILAR SK",
            "DOLUNAY SK", "DOST SK", "DOĞA SK", "DOĞAL SOKAK SK", "DOĞAN SK", "DOĞU SK", "DOĞUŞ SK", "DR MEHMET İBRAHİM CD",
            "DUATEPE SK", "DUMAN SK", "DUMANLI SK", "DUMLUPINAR SK", "DURAK SK", "DURU SK", "DUYARLI SK", "DUYGULU SK", "DUYUM SK",
            "DÖNEMEÇ SK", "DÜRÜST SK", "DÜZEN SK", "DÜZLEM SK", "DÜZTEPE SK", "DİCLE SK", "DİKKAYA SK", "DİKMEN SK", "DİKÇE SK",
            "DİLBER SK", "DİLEK SK", "DİNAMİK SK", "DİNÇER SK", "DİRLİK SK", "DİYAR SK", "EBEDİ SK", "EBRU SK", "ECD", "AT SK", "EDALI SK",
            "EFE SK", "EFLATUN SK", "EFSANE SK", "EKOL SK", "EKİN SK", "ELEMAN SK", "ELGAFDERE CD", "ELMALI SK", "ELMAS SK",
            "ELVAN SK", "ELİF SK", "EMEK CD", "EMEKTAR SK", "EMEKÇİLER SK", "EMRE KARAAĞAÇLI SK", "EMRE SK", "EMRULLAH SK",
            "EMSAL SK", "EMİN ALEMDAR SK", "EMİN SK", "EMİR SK", "EMİRGAN SK", "ENDER SK", "ENDÜSTRİ SK", "ENSAR SK", "ENİŞTE AHMET SK",
            "ERDEM SK", "ERDEMLİ SK", "ERDOĞDU UZUN SK", "EREN SK", "ERENLER SK", "ERZURUM YOLU CD", "ERİŞKİN SK", "ERİŞİM SK",
            "ESEN SK", "ESENLER SK", "ESENYALI SK", "ESENYURT SK", "ESER SK", "ESK", "İ DEMİRCİLER SK", "ESK", "İ MEKTEP ARALIĞI SK",
            "ESK", "İ MEKTEP SK", "ESK", "İ MEZARLIK SK", "ESTERGON SK", "EVLİYA CD", "EVRENDEDE SK", "EVİM CD", "EYÜBOĞLU CD",
            "EĞİTİM CD", "EŞREF BİTLİS CD", "FABRİKA ÇIKMAZI SK", "FARABİ CD", "FASILA SK", "FATİH CAMİİ SK", "FATİH CD", "FAVORİ SK",
            "FAİK AHMET BARUTÇU CD", "FAİK DRANAZ CD", "FENERCİLER SK", "FENERLİ SK", "FERAH SK", "FESTİVAL SK", "FEZA SK", "FIRAT SK", "FUNDA SK", "FİDAN SK", "FİDANLIK SK", "FİKİR SK", "FİKİRTEPE SK", "FİRUZE SK", "GAMLI SK", "GAMZE SK", "GANİTA SK", "GAZİ CD", "GAZİ MUSTAFA KEMAL CD", "GAZİPAŞA CD", "GAZİPAŞA ÇAYIR SK", "GEDİKLİ MAHMUT SK", "GEDİKLİ REMZİ SK", "GEDİKLİ SK", "GELİNCİK SK", "GELİŞİM SK", "GENÇLİK CD", "GENÇOĞLU SK", "GEYİKLİ SK", "GEÇİT SK", "GOLOĞLU SK", "GONCA SK", "GURBET SK", "GURUR SK", "GÖKKUŞAĞI SK", "GÖKSU SK", "GÖKTAŞ SK", "GÖKÇE SK", "GÖKÇEDENİZ SK", "GÖNÜL SK", "GÖRKEM SK", "GÖZLEM SK", "GÜL SK", "GÜLBAHÇE SK", "GÜLER SK", "GÜLGAZİ SK", "GÜLGÖNÜL SK", "GÜLHAN SK", "GÜLİSTAN SK", "GÜMÜŞ SK", "GÜMÜŞDERE SK", "GÜNDÜZ SK", "GÜNEY SK", "GÜNEŞ SK", "GÜNEŞTEPE SK", "GÜNGÖREN SK", "GÜRPINAR SK", "GÜVELİOĞLU CD", "GÜVEN SK", "GÜVERCİN SK", "GÜZEL SK", "GÜZELBAHÇE SK", "GÜZELCE SK", "GÜZELHİSAR CD", "GÜZELTEPE SK", "GÜZİDE SK", "GİŞE SK", "HACI AHMET SK", "HACI ARİF HAMAM SK", "HACI KAŞİF SK", "HACI MUSTAFA SK", "HACI VEHBİ EFENDİ SK", "HACI ZİYA HABİBOĞLU CD", "HACIOĞLU SK", "HAFIZ AHMET SK", "HAKİMİYET CD", "HALK SK", "HALKEVİ SK", "HALLAÇOĞLU SK", "HALİDE EDİP ADIVAR SK", "HAMAMİZADE SK", "HANECİ SK", "HANEDAN SK", "HANIMELİ SK", "HARMAN SK", "HARİTA CD", "HASAN BAŞ ÇIKMAZ SK", "HASAN SAKA CD", "HASAN TAHSİN SK", "HASAN ÇAVUŞ SK", "HASANPAŞA SK", "HASRET SK", "HASTAHANE CD", "HASTAHANE CİVARI SK", "HATIRA SK", "HATUNCUK CAMİİ SK", "HATİP CAMİİ SK", "HAVADAR SK", "HAYAT CD", "HAŞMET SK", "HAŞİM SK", "HAŞİMOĞLU SK", "HEKİMLER SK", "HEYBETLİ SK", "HIZIR SK", "HORON CD", "HOŞ SK", "HUZUR CD", "HUZURLU SK", "HÜRMET SK", "HÜRRİYET CD", "HÜSAMOĞLU SK", "HÜSAMOĞLU ÇIKMAZ SK", "HÜSEYİN KAZAZOĞLU SK", "HİDAYET SK", "HİLAL SK", "HİSAR SK", "IHLAMUR SK", "ISLAHANE SK", "IŞIK SK", "IŞIL SK", "İBNİ SİNA SK", "İBRAHİM ALEMDAĞ CD", "İBRAHİM ÇIKMAZI SK", "İBİŞOĞLU SK", "İBŞİROĞLU ÇIKMAZI SK", "İDEAL SK", "İFADE SK", "İFTİHAR SK", "İHLAS SK", "İKRAM SK", "İKİ ÇEŞME SK", "İLHAM SK", "LKADIM SK", "İLKE SK", "İLLER SK", "İLİM SK", "İMAM HATİP SK", "İMAM SK", "İMAM VEHBİ ÇIKMAZI SK", "İMAR SK", "İMARET DERESİ SK", "İMARET HAMAM SK", "İMECE SK", "İMREN SK", "İNCE SK", "İNCİ SK", "İNCİLER SK", "İNÖNÜ CD", "İPEK SK", "İPEKYOLU CD", "İPLİKÇİ ARİF SK", "İRAN CD", "İRFAN SK", "İSTİKBAL SK", "İSTİKLALSİ SK", "İZCİ SK", "İÇ SK", "KABİR SK", "KABİNE SK", "KADER CD", "KADIOĞLU SK", "KADİFE SK", "KAFKAS SK", "KAHRAMAN ÇIKMAZ SK", "KAHRAMANMARAŞ CD", "KAHYAOĞLU SK", "KAKTÜS SK", "KALAFATOĞLU SK", "KALAYCIOĞLU SK", "KALCIOĞLU SK", "KALCIYA CİVARI SK", "KALE ALTI SK", "KALEKAPI SK", "KALEKAPISI YoKUŞU SK", "KALEM SK", "KALFA SK", "KALHANE SK", "KALITIM SK", "KALKANOĞLU CD", "KALORİ SK", "KALİTE SK", "KAMASOĞLU SK", "KAMELYA SK", "KAMİL SK", "KANARYA SK", "KANAT SK", "KANDİL SK", "KANEPECİ SK", "KANTARCI SK", "KAPLAN SK", "KAPTAN SK", "KARA SK", "KARAALİ CD", "KARACA SK", "KARADENİZ SAHİL YOLUKARAHASAN SK", "KARAKAŞ SK", "KARAKAŞ ÇIKMAZI SK", "KARAKOLHANE SK", "KARANFİL SK", "KARAYEMİŞ SK", "KARBEYAZ SK", "KARDELEN SK", "KARDEŞ SK", "KARLI SK", "KARLIK CD", "KARLIK DEREİÇİ SK", "KARPUZ SK", "KARTALTEPE CD", "KARTOPU SK", "KARÇİÇEĞİ SK", "KARŞIYAKA CD", "KASIM SK", "KASIMOĞLU ÇIKMAZI SK", "KAVAKLI SK", "KAVAKMEYDAN SK", "KAYA SK", "KAYABAŞI SK", "KAYALIK SK", "KAYALIK TÜRBE SK", "KAYALIK ÇIKMAZI SK", "KAYMAKLI CD", "KAZANCILAR SK", "KAZAZ ÇIKMAZI SK", "KAZAZLAR SK", "KAZAZOĞLU SK", "KAŞ SK", "KAŞANBUR SK", "KEHRİBAR SK", "KELEBEK SK", "KEMER SK", "KEMERALTI SK", "KEMERLİDERE KAPTAN SK", "KENANOĞLU SK", "KENT SK", "KERPİÇ SK", "KERVAN SK", "KEVSER SK", "KEÇECİOĞLU SK", "KIBLE SK", "KIBRIS SK", "KILIÇ SK", "KINALITAŞ CD", "KIR MEVKİİ SK", "KIRAÇ SK", "KIRKBATTAL SK", "KIRSAL SK", "KIRÇİÇEĞİ SK", "KISA SK", "KISMET SK", "KIVILCIM SK", "KIYMET SK", "KIZILAY SK", "KIZILCIK SK", "KIZILTOPRAK SK", "KIŞLA SK", "KOLAĞASI SK", "KOLCU SK", "KOLÇAKOĞLU SK", "KONAK CD", "KONUK SK", "KONUT SK", "KORU SK", "KOZA SK", "KUDRETTİN CAMİİ SK", "KUKULTAŞ SK", "KULOĞLU SK", "KUMLU SK", "KUMRU SK", "KUNDUPOĞLU SK", "KUNDURACILAR CD", "KURAL SK", "KURAN KURSU CD", "KURBAN SK", "KURTULUŞ SK", "KURULAY SK", "KURUTAŞ SK", "KURUÇEŞME SK", "KUVVET SK", "KUYU SK", "KUYUMCULAR SK", "KUZEY KIBRIS SK", "KUZGUNDERE CD", "KUŞATAN SK", "KUŞBURNU SK", "KUŞKONMAZ SK", "KÖSEOĞLU CD", "KÖŞEM ÇIKMAZI SK", "KÖŞK CD", "KÜBRA SK", "KÜLLAÇ SK", "KÜLTÜR CD", "KÜPELİ SK", "KÜÇÜK SANAYİ SK", "KÜÇÜK SK", "KÜÇÜKBAHÇE SK", "KİLLİDERE SK", "KİRAZBOĞAZI SK", "KİSARNA CD", "KİTAP SK", "KİTAPÇI MEHMET SK", "LAKOTOĞLU SK", "LALE SK", "LATİFLİ SK", "LEVENT SK", "LEYLAK SK", "LOJMAN SK", "LÜTFULLAH SK", "LİMAN SK", "LİMONLU SK", "LİMONLU ÇIKMAZI SK", "LİSE SK", "MADEN SK", "MAHMUT GOLOĞLU CD", "MAKBER SK", "MALKOÇ DEREİÇİ SK", "MALKOÇOĞLU ÇIKMAZ SK", "MANOLYA SK", "MANZARALI SK", "MARANGOZ SK", "MARTI SK", "MAVİ SK", "MAVİŞ SK", "MEHMET AVNİ SK", "MEHMET KULAKSIZOĞLU SK", "MEHMET SK", "MEHMETCİK SK", "MEHTAP SK", "MEHTER SK", "MEKAN SK", "MEKTEP SK", "MEKTUP SK", "MELTEM SK", "MEMİŞ ÇIKMAZ SK", "MENEKŞE SK", "MENZİL SK", "MERCAN SK", "MERDİVENLİ SK", "MERT SK", "MERVE SK", "MERİÇ SK", "MESAFE SK", "MESCİT SK", "MESLEK SK", "MESUT SK", "METANET SK", "METİN SK", "MEVSİM SK", "MEYDAN CAMİİ SK", "MEYDAN HAMAM SK", "MEYDANCIK SK", "MEYVELİ SK", "MEZARLIK SK", "MEŞALE SK", "MEŞE SK", "MEŞGALE SK", "MISIRLI SK", "MISIRLIOĞLU ARALIĞI SK", "MISIRLIOĞLU SK", "MISRA SK", "MOLLA SİYAH CAMİİ SK", "MOLOZ CD", "MORA SK", "MORGÜL SK", "MUAZZAM SK", "MUHABBET SK", "MUHTAR ABDURRAHMAN SK", "MUHTAR COŞKUN KARAAĞAÇLI CD", "MUHTAR HARUN SK", "MUHTAR MEHMET SK", "MUHTAR MEHMET ÇIKMAZ SK", "MUHTAR OSMAN KIZILKAYA SK", "MUHTEŞEM SK", "MUHİTTİN CAMİİ SK", "MUHİTTİN SK", "MUKADDES SK", "MUMCULAR SK", "MUMCULAR ÇIKMAZI SK", "MUMHANE ÖNÜ MEYDANIMUSA PAŞA CAMİİ SK", "MUSTAFA ALEMDAĞ CD", "MUSTAFA NALÇACIOĞLU SK", "MUSTAFA RIFAT SK", "MUSTAFA SK", "MUTEBER SK", "MUTLU SK", "MUVAKKİTHANE SK", "MÜCAHİT SK", "MÜEZZİN SK", "MÜFTÜ CAMİİ SK", "MÜJDE SK", "MÜTEVELLİ SK", "MİLLİ EGEMENLİK CD", "MİMAR SK", "MİMAR SİNAN CD", "MİMOZA SK", "MİNARE SK", "MİNE SK", "MİNELİ SK", "MİNİ SK", "NADİDE SK", "NAME SK", "NANELİ SK", "NARLI SK", "NARLIBAHÇE SK", "NARÇİÇEĞİ SK", "NARİN SK", "NASİP SK", "NAZAR SK", "NAZLI SK", "NAZLICAN CD", "NAZLIÇEŞME SK", "NAZİFBEY SK", "NEHİR SK", "NEMLİOĞLU CEMAL SK", "NEMLİOĞLU KONAK SK", "NEMLİOĞLU MEHMET SALİH SK", "NEMLİOĞLU SK", "NEMLİOĞLU ÇIKMAZI SK", "NERGİS SK", "NEŞE SK", "NUHOĞLU SK", "NURETTİN DOĞAN CD", "NURGÜL SK", "NİLÜFER SK", "NİMET SK", "NİSA SK", "NİSAN SK", "NİYET SK", "OCAK SK", "OKUL SK", "OKYANUS SK", "ONUR SK", "ORDU SK", "ORKİDE SK", "ORTA SK", "ORTAK SK", "ORTANCA SK", "OSMAN NURİ AYDEMİR SK", "OYA SK", "OZAN SK", "ÖMER HAYALİ SK", "ÖMER TERZİ SK", "ÖMÜR SK", "ÖNDER SK", "ÖRNEK SK", "ÖZ SK", "ÖZBAK SK", "ÖZDEN SK", "ÖZEL SK", "ÖZGÜR CD", "ÖZGÜRLÜK SK", "ÖZLEM CD", "ÖZLENEN SK", "ÖZLÜ SK", "ÖZTÜRK SK", "ÖZYURT SK", "ÖĞRETMEN MEKTEP SK", "ÖĞRETMEN ÖMER ÇEBİ CD", "ÖĞRETİM SK", "PALMİYE SK", "PAMUKDEDE SK", "PAPATYA SK", "PARK SK", "PAZAR SK", "PAZARYOLU SK", "PAŞAHAMAM ARALIĞI SK", "PAŞAHAMAM GEÇİDİ SK", "PAŞAHAMAM SK", "PAŞALIOĞLU SK", "PEHLİVAN SK", "PELİN SK", "PELİNSU SK", "PEMBE SK", "PERTEVPAŞA SK", "PETEK SK", "PINAR SK", "PINARBAŞI SK", "PIRLANTA SK", "PLATİN SK", "POSTACI SK", "POSTAHANE SK", "POYRAZ SK", "PROF.OSMAN TURAN CD", "PULATHANE CD", "PİKNİK SK", "PİLOT SK", "PİROĞLU ÇIKMAZ SK", "PİRİ REİS CD", "RAFİNE SK", "RAHMET SK", "RAMPA SK", "REFORM SK", "REHBER SK", "REKABET SK", "REİS SK", "RIHTIM SK", "RUŞEN SK", "RÜYAM SK", "RÜZGAR SK", "RÜZGARLI BAYIR SK", "RÜZGARLI SK", "RÜZGARLIBAHÇE SK", "SAAT SK", "SAATÇI MEHMET SK", "SABAH SK", "SABIR SK", "SAHRA SK", "SAKA SK", "SAKALLIOĞLU SK", "SAKIZ MEYDANISAKİN SK", "SALI SK", "SALKIM SK", "SALİH AYDIN SK", "SALİH SK", "SALİH YAZICI SK", "SAMANYOLU SK", "SAMYELİ SK", "SANAYİ ÇARŞISI CD", "SANCAK SK", "SANDALCI SK", "SANDIKÇILAR SK", "SARAY SK", "SARAYATİK CAMİİ SK", "SARAYATİK SK", "SARAÇLAR SK", "SARDUNYA SK", "SARI SK", "SARIHASAN SK", "SARIÇİÇEK SK", "SARMAŞIK SK", "SARRAFLAR SK", "SARRAFOĞLU SK", "SAYGI SK", "SAYLAM SK", "SAYMANLAR SK", "SAĞLAM SK", "SAĞLIK SK", "SEBAT SK", "SEDEF SK", "SEDİR SK", "SEFA SK", "SEFER ÖZGÜR CD", "SELVA SK", "SELVİ SK", "SELÇUK AKYOL SK", "SELİM SK", "SEMA SK", "SEMERCİLER CD", "SERDAR CD", "SERHAT SK", "SERÇE SK", "SERİN SK", "SEVGİ SK", "SEVİM SK", "SEVİNÇ SK", "SEYFETTİN SK", "SEYHAN SK", "SEYRAN CD",
            "SEYRANTEPE CD", "SEZAİ UZAY CD", "SEZER SK", "SEÇKİN SK", "SEÇİM SK", "SILA SK", "SOFOĞLU SK", "SONBAHAR SK",
            "SONGÜL SK", "SOYLU SK", "SOĞANLI SK", "SOĞUK ÇEŞME SK", "SOĞUK ÇEŞME ÇIKMAZI SK", "SOĞUKSU CD",
            "SOĞUKSU ÇIKMAZI SK", "SPOR SK", "SU KÖPRÜSÜ SK", "SUAT OYMAN CD", "SUBAŞI SK", "SUBOYU SK", "SUDENAZ SK",
            "SULH SK", "SULTAN SK", "SUR SK", "SUSAM SK", "SÖKMEN SK", "SÖNMEZ SK", "SÖĞÜT SK", "SÜLEYMAN BARUTOĞLU SK",
            "SÜMBÜL SK", "SÜMER SK", "SÜRMELİ SK", "SÜVARİ SK", "SİMGE SK", "SİPAHİ SK", "SİRKECİLER YALIHAN SK", "SİTE SK",
            "SİYAMOĞLU SK", "ŞADIRVAN SK", "ŞAFAK SK", "ŞAHİN SK", "ŞAHİNKAYA SK", "ŞAHİNLER SK", "ŞAKAR SK", "ŞAKİR SK",
            "ŞAKİROĞLU SK", "ŞAMDAN SK", "ŞATIROĞLU SK", "ŞAİR SK", "ŞEFKAT SK", "ŞEHİR SK", "ŞEHİT BOZDAĞ SK", "ŞEHİT MEHMET ÇAKIR SK", "ŞEHİT SK", "ŞEHİTBABA SK", "ŞEKER SK", "ŞELALE SK", "ŞENKAYA SK", "ŞENLİK SK", "ŞENOL GÜNEŞ CD", "ŞEREF SK", "ŞH.ASTĞM.COŞKUN DAVULCU SK", "ŞH.ASTĞM.ORHAN SANCAR CD", "ŞH.AYHAN GÜNER SK", "ŞH.AYHAN İNCEKARA CD", "ŞH.ER AYTEKİN SK", "ŞH.ERCAN AYGÜN SK", "ŞH.FAHRETTİN SARI SK", "ŞH.HAKAN ÖZER SK", "ŞH.HALİL KARAGÖZ SK", "ŞH.HASAN AYDIN SK", "ŞH.OSMAN ERTOSUN CD", "ŞH.PİLOT METE ESAT SK", "ŞH.RAHMAN ŞEBER SK", "ŞH.REFİK CESUR CD", "ŞH.RIFAT TÜRE SK", "ŞH.TAHSİN ARIKAN SK", "ŞH.TĞM.YILMAZ ERDEMİR SK", "ŞH.ÖMER YILDIZ SK", "ŞH.İBRAHİM KARAOĞLANOĞLU CD", "ŞH.ŞENER SÜMER SK", "ŞÖHRET SK", "ŞÖLEN SK", "ŞİFA SK", "ŞİRİN HATUN SK", "ŞİRİN SK", "ŞİRİNTEPE SK", "TABAKHANE SK", "TABAKLAR SK", "TABYA SK", "TABİP SK", "TAFLAN SK", "TAHTALI CAMİİ SK", "TAKSİM CD", "TAKSİM HARKI SK", "TAKVİM SK", "TALİH SK", "TARAKÇILAR SK", "TARIM SK", "TARİH SK", "TAVANLI CAMİİ SK", "TAVANLI ÇIKAR SK", "TAYFUN SK", "TAÇ SK", "TAŞLIK SK", "TEK SK", "TEKELİOĞLU SK", "TEKKE CAMİİ SK", "TELLİ TABYA SK", "TELSİZTEPE CD", "TEMEL REİSSİ SK", "TEMEL ÇIKMAZI SK", "TEMİZ SK", "TEPE SK", "TEPEBAŞI SK", "TEPECİK SK", "TEPELİ ÇIKMAZI SK", "TERMİNAL SK", "TERTİP SK", "TERZİ SK", "TERZİLER SK", "TEVFİK SK", "TOMURCUK SK", "TOPAL HAKİM SK", "TOPHANE CAMİİ SK", "TOPHANE HAMAM SK", "TOPRAK SK", "TOPÇUOĞLU SK", "TOROS SK", "TOYGAROĞLU SK", "TRT SK", "TUFAN SK", "TUNA SK", "TUNCAY SK", "TUNÇ SK", "TURAN SK", "TURGUT ÖZAL BLTURNA SK", "TUZLU ÇEŞME SK", "TÜRBE SK", "TÜRKOĞLU SK", "TÜTÜN SK", "TİCARET MEKTEP SK", "TİCARET SK", "TİYATRO SK", "UFUK SK", "ULAŞ SK", "ULUS SK", "USTA SK", "USTAOĞLU SK", "UYGAR SK", "UYGUR SK", "UZUN SK", "UZUN İBRAHİMOĞLU SK", "UZUNOĞLU SK", "UĞUR SK", "UĞURLU SK", "UĞURLUSİ SK", "ÜMİT SK", "ÜNLÜ SK", "ÜNVER SK", "ÜRÜN SK", "ÜSTAD SK", "ÜSTÜN SK", "ÜZÜMLÜ SK", "VAKIFLAR SK", "VALİDE SK", "VARIŞ SK", "VATAN CD", "VEDA SK", "VEFA SK", "VEFAKAR SK", "VELİ SK", "VERİMLİ SK", "VOLKAN SK", "VUSLAT SK", "VİLLA SK", "VİŞNE SK", "YABANGÜLÜ SK", "YADİGAR SK", "YAHYA REİS SK", "YAKAMOZ SK", "YAKUP REİSOĞLU SK", "YAKUT SK", "YALDIZ SK", "YALI ARALIĞI SK", "YALI CD", "YALÇIN SK", "YALÇINKAYA SK", "YAMAÇ SK", "YAN SK", "YANIK HASAN REİS SK", "YANKI SK", "YAPRAK SK", "YAREN SK", "YARIMBIYIK SK", "YASEMİN SK", "YAVUZ SELİM BLYAVUZ SK", "YAYA SK", "YAYLA SK", "YAZAR SK", "YAZICIOĞLU SK", "YAZMA SK", "YAZMALI SK", "YAĞMUR SK", "YAŞAM CD", "YELKEN SK", "YEMEN SK", "YENER SK", "YENİ CAMİ CD", "YENİ SK", "YENİCE SK", "YENİCUMA CAMİİ ÇIKMAZI SK", "YENİCUMA CD", "YENİCUMA İZİR K3ÜK SK", "YENİDÜNYA SK", "YENİGÜN SK", "YERLİCE SK", "YETENEKLİ SK", "YEŞİL CD", "YEŞİLIRMAK SK", "YEŞİM SK", "YILDIRIM SK", "YILDIZ SK", "YILMAZ SK", "YOL SK", "YOLDAŞ SK", "YONCA SK", "YONCALI SK", "YOSUN SK", "YOĞUN SK", "YUDUM SK", "YUNUS SK", "YURT SK", "YURTTAŞ SK", "YUSUFOĞLU SK", "YUVA SK", "YÜCE SK", "YÜNCÜLER SK", "YÜZBAŞI EMRULLAH SK", "YÜZÜK SK", "YİRMİ4 ŞUBAT CD", "YİĞİT SK", "ZAFANOZ CD", "ZAFER SK", "ZAFERİ SK", "ZAKKUM SK", "ZAMBAK SK", "ZARİF SK", "ZAĞNOS CD", "ZAĞNOS DEREİÇİ SK", "ZAİMOĞLU SK", "ZEKİ SK", "ZERAFET SK", "ZEYTİNLİK CD", "ZIVALIOĞLU SK", "ZÜBEYDA HANIM CD", "ZÜHRE SK", "ZÜMRÜT SK", "ZİHİN SK", "ZİNCİRLİÇEŞME SK", "ZİRAAT SK", "ZİRVE SK", "ZİVER SK", "ZİYAD NEMLİ SANAT SK", "ZİYAFET SK", "ZİYARET SK"];


        $this->TaxOffices = array(
            1 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Merkez',
                            'office_code' => '1250',
                            'office_name' => 'Adana İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Merkez',
                            'office_code' => '1251',
                            'office_name' => '5 Ocak Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Merkez',
                            'office_code' => '1252',
                            'office_name' => 'Yüreğir Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Merkez',
                            'office_code' => '1253',
                            'office_name' => 'Seyhan Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Merkez',
                            'office_code' => '1254',
                            'office_name' => 'Ziyapaşa Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Merkez',
                            'office_code' => '1255',
                            'office_name' => 'Çukurova Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Ceyhan',
                            'office_code' => '1201',
                            'office_name' => 'Ceyhan Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Kozan',
                            'office_code' => '1203',
                            'office_name' => 'Kozan Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Karataş',
                            'office_code' => '1205',
                            'office_name' => 'Karataş Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Feke',
                            'office_code' => '1103',
                            'office_name' => 'Feke Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Karaisalı',
                            'office_code' => '1105',
                            'office_name' => 'Karaisalı Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Pozantı',
                            'office_code' => '1109',
                            'office_name' => 'Pozantı Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Saimbeyli',
                            'office_code' => '1110',
                            'office_name' => 'Saimbeyli Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Tufanbeyli',
                            'office_code' => '1111',
                            'office_name' => 'Tufanbeyli Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Yumurtalık',
                            'office_code' => '1112',
                            'office_name' => 'Yumurtalık Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'Aladağ',
                            'office_code' => '1114',
                            'office_name' => 'Aladağ Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 1,
                            'city_name' => 'ADANA',
                            'town_name' => 'İmamoğlu',
                            'office_code' => '1115',
                            'office_name' => 'İmamoğlu Malmüdürlüğü',
                        ),
                ),
            2 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Merkez',
                            'office_code' => '2260',
                            'office_name' => 'Adıyaman Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Kahta',
                            'office_code' => '2261',
                            'office_name' => 'Kahta Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Besni',
                            'office_code' => '2101',
                            'office_name' => 'Besni Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Çelikhan',
                            'office_code' => '2102',
                            'office_name' => 'Çelikhan Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Gerger',
                            'office_code' => '2103',
                            'office_name' => 'Gerger Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Gölbaşı',
                            'office_code' => '2104',
                            'office_name' => 'Gölbaşı Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Samsat',
                            'office_code' => '2106',
                            'office_name' => 'Samsat Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Sincik',
                            'office_code' => '2107',
                            'office_name' => 'Sincik Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 2,
                            'city_name' => 'ADIYAMAN',
                            'town_name' => 'Tut',
                            'office_code' => '2108',
                            'office_name' => 'Tut Malmüdürlüğü',
                        ),
                ),
            3 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Merkez',
                            'office_code' => '3201',
                            'office_name' => 'Tınaztepe Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Merkez',
                            'office_code' => '3280',
                            'office_name' => 'Kocatepe Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Dinar',
                            'office_code' => '3260',
                            'office_name' => 'Dinar Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Bolvadin',
                            'office_code' => '3261',
                            'office_name' => 'Bolvadin Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Emirdağ',
                            'office_code' => '3262',
                            'office_name' => 'Emirdağ Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Sandıklı',
                            'office_code' => '3263',
                            'office_name' => 'Sandıklı Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Çay',
                            'office_code' => '3202',
                            'office_name' => 'Çay Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Dazkırı',
                            'office_code' => '3103',
                            'office_name' => 'Dazkırı Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'İhsaniye',
                            'office_code' => '3105',
                            'office_name' => 'İhsaniye Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Sinanpaşa',
                            'office_code' => '3107',
                            'office_name' => 'Sinanpaşa Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Sultandağı',
                            'office_code' => '3108',
                            'office_name' => 'Sultandağı Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Şuhut',
                            'office_code' => '3109',
                            'office_name' => 'Şuhut Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Başmakçı',
                            'office_code' => '3111',
                            'office_name' => 'Başmakçı Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Bayat',
                            'office_code' => '3112',
                            'office_name' => 'Bayat Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'İscehisar',
                            'office_code' => '3264',
                            'office_name' => 'İscehisar Vergi Dairesi Müdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Çobanlar',
                            'office_code' => '3114',
                            'office_name' => 'Çobanlar Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Evciler',
                            'office_code' => '3115',
                            'office_name' => 'Evciler Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Hocalar',
                            'office_code' => '3116',
                            'office_name' => 'Hocalar Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 3,
                            'city_name' => 'AFYONKARAHİSAR',
                            'town_name' => 'Kızılören',
                            'office_code' => '3117',
                            'office_name' => 'Kızılören Malmüdürlüğü',
                        ),
                ),
            4 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 4,
                            'city_name' => 'AĞRI',
                            'town_name' => 'Merkez',
                            'office_code' => '4260',
                            'office_name' => 'Ağrı Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 4,
                            'city_name' => 'AĞRI',
                            'town_name' => 'Doğubeyazıt',
                            'office_code' => '4261',
                            'office_name' => 'Doğubeyazıt Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 4,
                            'city_name' => 'AĞRI',
                            'town_name' => 'Patnos',
                            'office_code' => '4262',
                            'office_name' => 'Patnos Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 4,
                            'city_name' => 'AĞRI',
                            'town_name' => 'Diyadin',
                            'office_code' => '4101',
                            'office_name' => 'Diyadin Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 4,
                            'city_name' => 'AĞRI',
                            'town_name' => 'Eleşkirt',
                            'office_code' => '4103',
                            'office_name' => 'Eleşkirt Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 4,
                            'city_name' => 'AĞRI',
                            'town_name' => 'Hamur',
                            'office_code' => '4104',
                            'office_name' => 'Hamur Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 4,
                            'city_name' => 'AĞRI',
                            'town_name' => 'Taşlıçay',
                            'office_code' => '4106',
                            'office_name' => 'Taşlıçay Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 4,
                            'city_name' => 'AĞRI',
                            'town_name' => 'Tutak',
                            'office_code' => '4107',
                            'office_name' => 'Tutak Malmüdürlüğü',
                        ),
                ),
            5 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 5,
                            'city_name' => 'AMASYA',
                            'town_name' => 'Merkez',
                            'office_code' => '5260',
                            'office_name' => 'Amasya Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 5,
                            'city_name' => 'AMASYA',
                            'town_name' => 'Merzifon',
                            'office_code' => '5261',
                            'office_name' => 'Merzifon Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 5,
                            'city_name' => 'AMASYA',
                            'town_name' => 'Gümüşhacıköy',
                            'office_code' => '5262',
                            'office_name' => 'Gümüşhacıköy Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 5,
                            'city_name' => 'AMASYA',
                            'town_name' => 'Taşova',
                            'office_code' => '5263',
                            'office_name' => 'Taşova Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 5,
                            'city_name' => 'AMASYA',
                            'town_name' => 'Suluova',
                            'office_code' => '5264',
                            'office_name' => 'Suluova Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 5,
                            'city_name' => 'AMASYA',
                            'town_name' => 'Göynücek',
                            'office_code' => '5101',
                            'office_name' => 'Göynücek Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 5,
                            'city_name' => 'AMASYA',
                            'town_name' => 'Hamamözü',
                            'office_code' => '5106',
                            'office_name' => 'Hamamözü Malmüdürlüğü',
                        ),
                ),
            6 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6280',
                            'office_name' => 'Anadolu İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6281',
                            'office_name' => 'Ankara İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6253',
                            'office_name' => 'Kavaklıdere Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6268',
                            'office_name' => 'Hitit Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6271',
                            'office_name' => 'Ostim Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6252',
                            'office_name' => 'Veraset ve Harçlar Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6254',
                            'office_name' => 'Maltepe Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6255',
                            'office_name' => 'Yenimahalle Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6257',
                            'office_name' => 'Çankaya Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6258',
                            'office_name' => 'Kızılbey Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6259',
                            'office_name' => 'Mithatpaşa Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6260',
                            'office_name' => 'Ulus Vergi Dairesi Müdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6261',
                            'office_name' => 'Yıldırım Beyazıt Vergi Dairesi Müdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6262',
                            'office_name' => 'Seğmenler Vergi Dairesi Müdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6264',
                            'office_name' => 'Dikimevi Vergi Dairesi Müdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6265',
                            'office_name' => 'Doğanbey Vergi Dairesi Müdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6266',
                            'office_name' => 'Yeğenbey Vergi Dairesi Müdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6269',
                            'office_name' => 'Yahya Galip Vergi Dairesi Müdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6270',
                            'office_name' => 'Muhammet Karagüzel Vergi Dairesi Müdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6272',
                            'office_name' => 'Gölbaşı Vergi Dairesi Müdürlüğü',
                        ),
                    20 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6273',
                            'office_name' => 'Sincan Vergi Dairesi Müdürlüğü',
                        ),
                    21 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6274',
                            'office_name' => 'Dışkapı Vergi Dairesi Müdürlüğü',
                        ),
                    22 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6275',
                            'office_name' => 'Etimesgut Vergi Dairesi Müdürlüğü',
                        ),
                    23 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6276',
                            'office_name' => 'Başkent Vergi Dairesi Müdürlüğü',
                        ),
                    24 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6277',
                            'office_name' => 'Cumhuriyet Vergi Dairesi Müdürlüğü',
                        ),
                    25 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez',
                            'office_code' => '6278',
                            'office_name' => 'Keçiören Vergi Dairesi Müdürlüğü',
                        ),
                    26 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '6279 Kahramankazan Vergi Dairesi Müdürlüğü',
                        ),
                    27 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Polatlı',
                            'office_code' => '6205',
                            'office_name' => 'Polatlı Vergi Dairesi Müdürlüğü',
                        ),
                    28 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Şereflikoçhisar',
                            'office_code' => '6207',
                            'office_name' => 'Şereflikoçhisar Vergi Dairesi Müdürlüğü',
                        ),
                    29 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Beypazarı',
                            'office_code' => '6209',
                            'office_name' => 'Beypazarı Vergi Dairesi Müdürlüğü',
                        ),
                    30 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '6211 Çubuk Vergi Dairesi Müdürlüğü',
                        ),
                    31 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Haymana',
                            'office_code' => '6213',
                            'office_name' => 'Haymana Vergi Dairesi Müdürlüğü',
                        ),
                    32 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '6215 Elmadağ Vergi Dairesi Müdürlüğü',
                        ),
                    33 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '6102 Ayaş Malmüdürlüğü',
                        ),
                    34 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '6103 Balâ Malmüdürlüğü',
                        ),
                    35 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Çamlıdere',
                            'office_code' => '6106',
                            'office_name' => 'Çamlıdere Malmüdürlüğü',
                        ),
                    36 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Güdül',
                            'office_code' => '6110',
                            'office_name' => 'Güdül Malmüdürlüğü',
                        ),
                    37 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '6112 Kalecik Malmüdürlüğü',
                        ),
                    38 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Kızılcahamam',
                            'office_code' => '6115',
                            'office_name' => 'Kızılcahamam Malmüdürlüğü',
                        ),
                    39 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Nallıhan',
                            'office_code' => '6117',
                            'office_name' => 'Nallıhan Malmüdürlüğü',
                        ),
                    40 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '6125 Akyurt Malmüdürlüğü',
                        ),
                    41 =>
                        array(
                            'plate_no' => 6,
                            'city_name' => 'ANKARA',
                            'town_name' => 'Evren',
                            'office_code' => '6127',
                            'office_name' => 'Evren Malmüdürlüğü',
                        ),
                ),
            7 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Merkez',
                            'office_code' => '7255',
                            'office_name' => 'Antalya Kurumlar Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Merkez',
                            'office_code' => '7256',
                            'office_name' => 'Antalya İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Merkez',
                            'office_code' => '7251',
                            'office_name' => 'Üçkapılar Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Merkez',
                            'office_code' => '7252',
                            'office_name' => 'Kalekapı Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Merkez',
                            'office_code' => '7253',
                            'office_name' => 'Muratpaşa Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Merkez',
                            'office_code' => '7254',
                            'office_name' => 'Düden Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Alanya',
                            'office_code' => '7201',
                            'office_name' => 'Alanya Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Serik',
                            'office_code' => '7202',
                            'office_name' => 'Serik Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Manavgat',
                            'office_code' => '7203',
                            'office_name' => 'Manavgat Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Elmalı',
                            'office_code' => '7204',
                            'office_name' => 'Elmalı Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Kemer',
                            'office_code' => '7205',
                            'office_name' => 'Kemer Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Kumluca',
                            'office_code' => '7206',
                            'office_name' => 'Kumluca Vergi Dairesi Müdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Finike',
                            'office_code' => '7104',
                            'office_name' => 'Finike Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Akseki',
                            'office_code' => '7101',
                            'office_name' => 'Akseki Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Gazipaşa',
                            'office_code' => '7105',
                            'office_name' => 'Gazipaşa Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Gündoğmuş',
                            'office_code' => '7106',
                            'office_name' => 'Gündoğmuş Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Kaş',
                            'office_code' => '7107',
                            'office_name' => 'Kaş Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Korkuteli',
                            'office_code' => '7108',
                            'office_name' => 'Korkuteli Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'Demre',
                            'office_code' => '7112',
                            'office_name' => 'Demre Malmüdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 7,
                            'city_name' => 'ANTALYA',
                            'town_name' => 'İbradı',
                            'office_code' => '7113',
                            'office_name' => 'İbradı Malmüdürlüğü',
                        ),
                ),
            8 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 8,
                            'city_name' => 'ARTVİN',
                            'town_name' => 'Merkez',
                            'office_code' => '8260',
                            'office_name' => 'Artvin Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 8,
                            'city_name' => 'ARTVİN',
                            'town_name' => 'Hopa',
                            'office_code' => '8261',
                            'office_name' => 'Hopa Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 8,
                            'city_name' => 'ARTVİN',
                            'town_name' => 'Arhavi',
                            'office_code' => '8262',
                            'office_name' => 'Arhavi Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 8,
                            'city_name' => 'ARTVİN',
                            'town_name' => 'Ardanuç',
                            'office_code' => '8101',
                            'office_name' => 'Ardanuç Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 8,
                            'city_name' => 'ARTVİN',
                            'town_name' => 'Borçka',
                            'office_code' => '8103',
                            'office_name' => 'Borçka Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 8,
                            'city_name' => 'ARTVİN',
                            'town_name' => 'Şavşat',
                            'office_code' => '8105',
                            'office_name' => 'Şavşat Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 8,
                            'city_name' => 'ARTVİN',
                            'town_name' => 'Yusufeli',
                            'office_code' => '8106',
                            'office_name' => 'Yusufeli Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 8,
                            'city_name' => 'ARTVİN',
                            'town_name' => 'Murgul',
                            'office_code' => '8107',
                            'office_name' => 'Murgul Malmüdürlüğü',
                        ),
                ),
            9 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Merkez',
                            'office_code' => '9201',
                            'office_name' => 'Efeler Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Merkez',
                            'office_code' => '9280',
                            'office_name' => 'Güzelhisar Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Nazilli',
                            'office_code' => '9260',
                            'office_name' => 'Nazilli Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Söke',
                            'office_code' => '9261',
                            'office_name' => 'Söke Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Çine',
                            'office_code' => '9262',
                            'office_name' => 'Çine Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Germencik',
                            'office_code' => '9263',
                            'office_name' => 'Germencik Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Kuşadası',
                            'office_code' => '9265',
                            'office_name' => 'Kuşadası Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Didim',
                            'office_code' => '9281',
                            'office_name' => 'Didim Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Bozdoğan',
                            'office_code' => '9101',
                            'office_name' => 'Bozdoğan Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Karacasu',
                            'office_code' => '9104',
                            'office_name' => 'Karacasu Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Koçarlı',
                            'office_code' => '9105',
                            'office_name' => 'Koçarlı Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Kuyucak',
                            'office_code' => '9107',
                            'office_name' => 'Kuyucak Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Sultanhisar',
                            'office_code' => '9110',
                            'office_name' => 'Sultanhisar Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Yenipazar',
                            'office_code' => '9111',
                            'office_name' => 'Yenipazar Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Buharkent',
                            'office_code' => '9112',
                            'office_name' => 'Buharkent Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'İncirliova',
                            'office_code' => '9113',
                            'office_name' => 'İncirliova Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Karpuzlu',
                            'office_code' => '9114',
                            'office_name' => 'Karpuzlu Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 9,
                            'city_name' => 'AYDIN',
                            'town_name' => 'Köşk',
                            'office_code' => '9115',
                            'office_name' => 'Köşk Malmüdürlüğü',
                        ),
                ),
            10 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Merkez',
                            'office_code' => '10201',
                            'office_name' => 'Karesi Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Merkez',
                            'office_code' => '10280',
                            'office_name' => 'Kurtdereli Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Ayvalık',
                            'office_code' => '10260',
                            'office_name' => 'Ayvalık Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Bandırma',
                            'office_code' => '10261',
                            'office_name' => 'Bandırma Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Burhaniye',
                            'office_code' => '10262',
                            'office_name' => 'Burhaniye Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Edremit',
                            'office_code' => '10263',
                            'office_name' => 'Edremit Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Gönen',
                            'office_code' => '10264',
                            'office_name' => 'Gönen Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Susurluk',
                            'office_code' => '10265',
                            'office_name' => 'Susurluk Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Erdek',
                            'office_code' => '10266',
                            'office_name' => 'Erdek Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Bigadiç',
                            'office_code' => '10267',
                            'office_name' => 'Bigadiç Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Sındırgı',
                            'office_code' => '10268',
                            'office_name' => 'Sındırgı Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Dursunbey',
                            'office_code' => '10269',
                            'office_name' => 'Dursunbey Vergi Dairesi Müdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Balya',
                            'office_code' => '10102',
                            'office_name' => 'Balya Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Havran',
                            'office_code' => '10110',
                            'office_name' => 'Havran Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'İvrindi',
                            'office_code' => '10111',
                            'office_name' => 'İvrindi Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Kepsut',
                            'office_code' => '10112',
                            'office_name' => 'Kepsut Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Manyas',
                            'office_code' => '10113',
                            'office_name' => 'Manyas Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Savaştepe',
                            'office_code' => '10114',
                            'office_name' => 'Savaştepe Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Marmara',
                            'office_code' => '10117',
                            'office_name' => 'Marmara Malmüdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 10,
                            'city_name' => 'BALIKESİR',
                            'town_name' => 'Gömeç',
                            'office_code' => '10118',
                            'office_name' => 'Gömeç Malmüdürlüğü',
                        ),
                ),
            11 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 11,
                            'city_name' => 'BİLECİK',
                            'town_name' => 'Merkez',
                            'office_code' => '11260',
                            'office_name' => 'Bilecik Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 11,
                            'city_name' => 'BİLECİK',
                            'town_name' => 'Bozüyük',
                            'office_code' => '11261',
                            'office_name' => 'Bozüyük Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 11,
                            'city_name' => 'BİLECİK',
                            'town_name' => 'Gölpazarı',
                            'office_code' => '11102',
                            'office_name' => 'Gölpazarı Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 11,
                            'city_name' => 'BİLECİK',
                            'town_name' => 'Osmaneli',
                            'office_code' => '11103',
                            'office_name' => 'Osmaneli Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 11,
                            'city_name' => 'BİLECİK',
                            'town_name' => 'Pazaryeri',
                            'office_code' => '11104',
                            'office_name' => 'Pazaryeri Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 11,
                            'city_name' => 'BİLECİK',
                            'town_name' => 'Söğüt',
                            'office_code' => '11105',
                            'office_name' => 'Söğüt Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 11,
                            'city_name' => 'BİLECİK',
                            'town_name' => 'Yenipazar',
                            'office_code' => '11106',
                            'office_name' => 'Yenipazar Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 11,
                            'city_name' => 'BİLECİK',
                            'town_name' => 'İnhisar',
                            'office_code' => '11107',
                            'office_name' => 'İnhisar Malmüdürlüğü',
                        ),
                ),
            12 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 12,
                            'city_name' => 'BİNGÖL',
                            'town_name' => 'Merkez',
                            'office_code' => '12260',
                            'office_name' => 'Bingöl Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 12,
                            'city_name' => 'BİNGÖL',
                            'town_name' => 'Genç',
                            'office_code' => '12101',
                            'office_name' => 'Genç Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 12,
                            'city_name' => 'BİNGÖL',
                            'town_name' => 'Karlıova',
                            'office_code' => '12102',
                            'office_name' => 'Karlıova Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 12,
                            'city_name' => 'BİNGÖL',
                            'town_name' => 'Kiğı',
                            'office_code' => '12103',
                            'office_name' => 'Kiğı Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 12,
                            'city_name' => 'BİNGÖL',
                            'town_name' => 'Solhan',
                            'office_code' => '12104',
                            'office_name' => 'Solhan Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 12,
                            'city_name' => 'BİNGÖL',
                            'town_name' => 'Adaklı',
                            'office_code' => '12105',
                            'office_name' => 'Adaklı Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 12,
                            'city_name' => 'BİNGÖL',
                            'town_name' => 'Yayladere',
                            'office_code' => '12106',
                            'office_name' => 'Yayladere Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 12,
                            'city_name' => 'BİNGÖL',
                            'town_name' => 'Yedisu',
                            'office_code' => '12107',
                            'office_name' => 'Yedisu Malmüdürlüğü',
                        ),
                ),
            13 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 13,
                            'city_name' => 'BİTLİS',
                            'town_name' => 'Merkez',
                            'office_code' => '13260',
                            'office_name' => 'Bitlis Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 13,
                            'city_name' => 'BİTLİS',
                            'town_name' => 'Tatvan',
                            'office_code' => '13261',
                            'office_name' => 'Tatvan Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 13,
                            'city_name' => 'BİTLİS',
                            'town_name' => 'Adilcevaz',
                            'office_code' => '13101',
                            'office_name' => 'Adilcevaz Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 13,
                            'city_name' => 'BİTLİS',
                            'town_name' => 'Ahlat',
                            'office_code' => '13102',
                            'office_name' => 'Ahlat Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 13,
                            'city_name' => 'BİTLİS',
                            'town_name' => 'Hizan',
                            'office_code' => '13103',
                            'office_name' => 'Hizan Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 13,
                            'city_name' => 'BİTLİS',
                            'town_name' => 'Mutki',
                            'office_code' => '13104',
                            'office_name' => 'Mutki Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 13,
                            'city_name' => 'BİTLİS',
                            'town_name' => 'Göroymak',
                            'office_code' => '13106',
                            'office_name' => 'Güroymak Malmüdürlüğü',
                        ),
                ),
            14 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Merkez',
                            'office_code' => '14260',
                            'office_name' => 'Bolu Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Gerede',
                            'office_code' => '14262',
                            'office_name' => 'Gerede Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Göynük',
                            'office_code' => '14104',
                            'office_name' => 'Göynük Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Kıbrıscık',
                            'office_code' => '14105',
                            'office_name' => 'Kıbrıscık Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Mengen',
                            'office_code' => '14106',
                            'office_name' => 'Mengen Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Mudurnu',
                            'office_code' => '14107',
                            'office_name' => 'Mudurnu Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Seben',
                            'office_code' => '14108',
                            'office_name' => 'Seben Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Dörtdivan',
                            'office_code' => '14113',
                            'office_name' => 'Dörtdivan Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 14,
                            'city_name' => 'BOLU',
                            'town_name' => 'Yeniçağa',
                            'office_code' => '14114',
                            'office_name' => 'Yeniçağa Malmüdürlüğü',
                        ),
                ),
            15 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Merkez',
                            'office_code' => '15260',
                            'office_name' => 'Burdur Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Bucak',
                            'office_code' => '15261',
                            'office_name' => 'Bucak Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Ağlasun',
                            'office_code' => '15101',
                            'office_name' => 'Ağlasun Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Gölhisar',
                            'office_code' => '15103',
                            'office_name' => 'Gölhisar Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Tefenni',
                            'office_code' => '15104',
                            'office_name' => 'Tefenni Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Yeşilova',
                            'office_code' => '15105',
                            'office_name' => 'Yeşilova Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Karamanlı',
                            'office_code' => '15106',
                            'office_name' => 'Karamanlı Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Kemer',
                            'office_code' => '15107',
                            'office_name' => 'Kemer Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Altınyayla',
                            'office_code' => '15108',
                            'office_name' => 'Altınyayla Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Çavdır',
                            'office_code' => '15109',
                            'office_name' => 'Çavdır Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 15,
                            'city_name' => 'BURDUR',
                            'town_name' => 'Çeltikçi',
                            'office_code' => '15110',
                            'office_name' => 'Çeltikçi Malmüdürlüğü',
                        ),
                ),
            16 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16250',
                            'office_name' => 'Bursa İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16251',
                            'office_name' => 'Osmangazi Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16252',
                            'office_name' => 'Yıldırım Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16253',
                            'office_name' => 'Çekirge Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16254',
                            'office_name' => 'Setbaşı Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16255',
                            'office_name' => 'Uludağ Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16256',
                            'office_name' => 'Yeşil Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16257',
                            'office_name' => 'Nilüfer Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16258',
                            'office_name' => 'Ertuğrulgazi Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez',
                            'office_code' => '16259',
                            'office_name' => 'Gökdere Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '16201 Gemlik Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'İnegöl',
                            'office_code' => '16202',
                            'office_name' => 'İnegöl Vergi Dairesi Müdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Karacabey',
                            'office_code' => '16203',
                            'office_name' => 'Karacabey Vergi Dairesi Müdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Mustafakemalpaşa',
                            'office_code' => '16204',
                            'office_name' => 'Mustafakemalpaşa Vergi Dairesi Müdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '16205 Mudanya Vergi Dairesi Müdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Orhangazi',
                            'office_code' => '16206',
                            'office_name' => 'Orhangazi Vergi Dairesi Müdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'İznik',
                            'office_code' => '16207',
                            'office_name' => 'İznik Vergi Dairesi Müdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Yenişehir',
                            'office_code' => '16208',
                            'office_name' => 'Yenişehir Vergi Dairesi Müdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Keles',
                            'office_code' => '16105',
                            'office_name' => 'Keles Malmüdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Orhaneli',
                            'office_code' => '16108',
                            'office_name' => 'Orhaneli Malmüdürlüğü',
                        ),
                    20 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Harmancık',
                            'office_code' => '16111',
                            'office_name' => 'Harmancık Malmüdürlüğü',
                        ),
                    21 =>
                        array(
                            'plate_no' => 16,
                            'city_name' => 'BURSA',
                            'town_name' => 'Büyükorhan',
                            'office_code' => '16112',
                            'office_name' => 'Büyükorhan Malmüdürlüğü',
                        ),
                ),
            17 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Merkez',
                            'office_code' => '17260',
                            'office_name' => 'Çanakkale Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Biga',
                            'office_code' => '17261',
                            'office_name' => 'Biga Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Çan',
                            'office_code' => '17262',
                            'office_name' => 'Çan Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Gelibolu',
                            'office_code' => '17263',
                            'office_name' => 'Gelibolu Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Ayvacık',
                            'office_code' => '17101',
                            'office_name' => 'Ayvacık Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Bayramiç',
                            'office_code' => '17102',
                            'office_name' => 'Bayramiç Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Bozcaada',
                            'office_code' => '17104',
                            'office_name' => 'Bozcaada Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Eceabat',
                            'office_code' => '17106',
                            'office_name' => 'Eceabat Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Ezine',
                            'office_code' => '17107',
                            'office_name' => 'Ezine Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Gökçeada',
                            'office_code' => '17109',
                            'office_name' => 'Gökçeada Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Lapseki',
                            'office_code' => '17110',
                            'office_name' => 'Lapseki Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 17,
                            'city_name' => 'ÇANAKKALE',
                            'town_name' => 'Yenice',
                            'office_code' => '17111',
                            'office_name' => 'Yenice Malmüdürlüğü',
                        ),
                ),
            18 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Merkez',
                            'office_code' => '18260',
                            'office_name' => 'Çankırı Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Çerkeş',
                            'office_code' => '18101',
                            'office_name' => 'Çerkeş Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Eldivan',
                            'office_code' => '18102',
                            'office_name' => 'Eldivan Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Ilgaz',
                            'office_code' => '18104',
                            'office_name' => 'Ilgaz Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Kurşunlu',
                            'office_code' => '18105',
                            'office_name' => 'Kurşunlu Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Orta',
                            'office_code' => '18106',
                            'office_name' => 'Orta Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Şabanözü',
                            'office_code' => '18108',
                            'office_name' => 'Şabanözü Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Yapraklı',
                            'office_code' => '18109',
                            'office_name' => 'Yapraklı Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Atkaracalar',
                            'office_code' => '18110',
                            'office_name' => 'Atkaracalar Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Kızılırmak',
                            'office_code' => '18111',
                            'office_name' => 'Kızılırmak Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Bayramören',
                            'office_code' => '18112',
                            'office_name' => 'Bayramören Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 18,
                            'city_name' => 'ÇANKIRI',
                            'town_name' => 'Korgun',
                            'office_code' => '18113',
                            'office_name' => 'Korgun Malmüdürlüğü',
                        ),
                ),
            19 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Merkez',
                            'office_code' => '19260',
                            'office_name' => 'Çorum Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Sungurlu',
                            'office_code' => '19261',
                            'office_name' => 'Sungurlu Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Alaca',
                            'office_code' => '19101',
                            'office_name' => 'Alaca Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Bayat',
                            'office_code' => '19102',
                            'office_name' => 'Bayat Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'İskilip',
                            'office_code' => '19103',
                            'office_name' => 'İskilip Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Kargı',
                            'office_code' => '19104',
                            'office_name' => 'Kargı Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Mecitözü',
                            'office_code' => '19105',
                            'office_name' => 'Mecitözü Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Ortaköy',
                            'office_code' => '19106',
                            'office_name' => 'Ortaköy Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Osmancık',
                            'office_code' => '19107',
                            'office_name' => 'Osmancık Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Boğazkale',
                            'office_code' => '19109',
                            'office_name' => 'Boğazkale Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Uğurludağ',
                            'office_code' => '19110',
                            'office_name' => 'Uğurludağ Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Dodurga',
                            'office_code' => '19111',
                            'office_name' => 'Dodurga Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Oğuzlar',
                            'office_code' => '19112',
                            'office_name' => 'Oğuzlar Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 19,
                            'city_name' => 'ÇORUM',
                            'town_name' => 'Laçin',
                            'office_code' => '19113',
                            'office_name' => 'Laçin Malmüdürlüğü',
                        ),
                ),
            20 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Merkez',
                            'office_code' => '20202',
                            'office_name' => 'Çınar Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Merkez',
                            'office_code' => '20203',
                            'office_name' => 'Gökpınar Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Merkez',
                            'office_code' => '20201',
                            'office_name' => 'Saraylar Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Merkez',
                            'office_code' => '20250',
                            'office_name' => 'Denizli İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Merkez',
                            'office_code' => '20280',
                            'office_name' => 'Pamukkale Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Sarayköy',
                            'office_code' => '20260',
                            'office_name' => 'Sarayköy Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Acıpayam',
                            'office_code' => '20261',
                            'office_name' => 'Acıpayam Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Tavas',
                            'office_code' => '20262',
                            'office_name' => 'Tavas Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Buldan',
                            'office_code' => '20263',
                            'office_name' => 'Buldan Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Çal',
                            'office_code' => '20264',
                            'office_name' => 'Çal Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Çivril',
                            'office_code' => '20265',
                            'office_name' => 'Çivril Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Çameli',
                            'office_code' => '20104',
                            'office_name' => 'Çameli Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Çardak',
                            'office_code' => '20105',
                            'office_name' => 'Çardak Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Güney',
                            'office_code' => '20107',
                            'office_name' => 'Güney Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Kale',
                            'office_code' => '20108',
                            'office_name' => 'Kale Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Babadağ',
                            'office_code' => '20111',
                            'office_name' => 'Babadağ Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Bekilli',
                            'office_code' => '20112',
                            'office_name' => 'Bekilli Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Honaz',
                            'office_code' => '20113',
                            'office_name' => 'Honaz Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Serinhisar',
                            'office_code' => '20114',
                            'office_name' => 'Serinhisar Malmüdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Akköy',
                            'office_code' => '20115',
                            'office_name' => 'Akköy Malmüdürlüğü',
                        ),
                    20 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Baklan',
                            'office_code' => '20116',
                            'office_name' => 'Baklan Malmüdürlüğü',
                        ),
                    21 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Beyağaç',
                            'office_code' => '20117',
                            'office_name' => 'Beyağaç Malmüdürlüğü',
                        ),
                    22 =>
                        array(
                            'plate_no' => 20,
                            'city_name' => 'DENİZLİ',
                            'town_name' => 'Bozkurt',
                            'office_code' => '20118',
                            'office_name' => 'Bozkurt Malmüdürlüğü',
                        ),
                ),
            21 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Merkez',
                            'office_code' => '21251',
                            'office_name' => 'Gökalp Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Merkez',
                            'office_code' => '21281',
                            'office_name' => 'Süleyman Nazif Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Merkez',
                            'office_code' => '21282',
                            'office_name' => 'Cahit Sıtkı Tarancı Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Bismil',
                            'office_code' => '21101',
                            'office_name' => 'Bismil Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Çermik',
                            'office_code' => '21102',
                            'office_name' => 'Çermik Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Çınar',
                            'office_code' => '21103',
                            'office_name' => 'Çınar Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Çüngüş',
                            'office_code' => '21104',
                            'office_name' => 'Çüngüş Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Dicle',
                            'office_code' => '21105',
                            'office_name' => 'Dicle Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Ergani',
                            'office_code' => '21106',
                            'office_name' => 'Ergani Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Hani',
                            'office_code' => '21107',
                            'office_name' => 'Hani Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Hazro',
                            'office_code' => '21108',
                            'office_name' => 'Hazro Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Kulp',
                            'office_code' => '21109',
                            'office_name' => 'Kulp Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Lice',
                            'office_code' => '21110',
                            'office_name' => 'Lice Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Silvan',
                            'office_code' => '21111',
                            'office_name' => 'Silvan Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Eğil',
                            'office_code' => '21112',
                            'office_name' => 'Eğil Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 21,
                            'city_name' => 'DİYARBAKIR',
                            'town_name' => 'Kocaköy',
                            'office_code' => '21113',
                            'office_name' => 'Kocaköy Malmüdürlüğü',
                        ),
                ),
            22 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Merkez',
                            'office_code' => '22201',
                            'office_name' => 'Arda Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Merkez',
                            'office_code' => '22260',
                            'office_name' => 'Kırkpınar Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Keşan',
                            'office_code' => '22261',
                            'office_name' => 'Keşan Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Uzunköprü',
                            'office_code' => '22262',
                            'office_name' => 'Uzunköprü Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Havsa',
                            'office_code' => '22263',
                            'office_name' => 'Havsa Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'İpsala',
                            'office_code' => '22264',
                            'office_name' => 'İpsala Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Enez',
                            'office_code' => '22101',
                            'office_name' => 'Enez Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Lalapaşa',
                            'office_code' => '22105',
                            'office_name' => 'Lalapaşa Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Meriç',
                            'office_code' => '22106',
                            'office_name' => 'Meriç Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 22,
                            'city_name' => 'EDİRNE',
                            'town_name' => 'Süloğlu',
                            'office_code' => '22108',
                            'office_name' => 'Süloğlu Malmüdürlüğü',
                        ),
                ),
            23 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Merkez',
                            'office_code' => '23201',
                            'office_name' => 'Harput Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Merkez',
                            'office_code' => '23280',
                            'office_name' => 'Hazar Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Ağın',
                            'office_code' => '23101',
                            'office_name' => 'Ağın Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Baskil',
                            'office_code' => '23102',
                            'office_name' => 'Baskil Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Karakoçan',
                            'office_code' => '23103',
                            'office_name' => 'Karakoçan Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Keban',
                            'office_code' => '23104',
                            'office_name' => 'Keban Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Maden',
                            'office_code' => '23105',
                            'office_name' => 'Maden Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Palu',
                            'office_code' => '23106',
                            'office_name' => 'Palu Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Sivrice',
                            'office_code' => '23107',
                            'office_name' => 'Sivrice Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Arıcak',
                            'office_code' => '23108',
                            'office_name' => 'Arıcak Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Kovancılar',
                            'office_code' => '23109',
                            'office_name' => 'Kovancılar Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 23,
                            'city_name' => 'ELAZIĞ',
                            'town_name' => 'Alacakaya',
                            'office_code' => '23110',
                            'office_name' => 'Alacakaya Malmüdürlüğü',
                        ),
                ),
            24 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'Merkez',
                            'office_code' => '24260',
                            'office_name' => 'Fevzipaşa Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'Çayırlı',
                            'office_code' => '24101',
                            'office_name' => 'Çayırlı Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'İliç',
                            'office_code' => '24102',
                            'office_name' => 'İliç Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'Kemah',
                            'office_code' => '24103',
                            'office_name' => 'Kemah Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'Kemaliye',
                            'office_code' => '24104',
                            'office_name' => 'Kemaliye Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'Refahiye',
                            'office_code' => '24105',
                            'office_name' => 'Refahiye Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'Tercan',
                            'office_code' => '24106',
                            'office_name' => 'Tercan Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'Üzümlü',
                            'office_code' => '24107',
                            'office_name' => 'Üzümlü Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 24,
                            'city_name' => 'ERZİNCAN',
                            'town_name' => 'Otlukbeli',
                            'office_code' => '24108',
                            'office_name' => 'Otlukbeli Malmüdürlüğü',
                        ),
                ),
            25 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Merkez',
                            'office_code' => '25251',
                            'office_name' => 'Aziziye Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Merkez',
                            'office_code' => '25280',
                            'office_name' => 'Kazımkarabekir Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Aşkale',
                            'office_code' => '25101',
                            'office_name' => 'Aşkale Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Çat',
                            'office_code' => '25102',
                            'office_name' => 'Çat Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Hınıs',
                            'office_code' => '25103',
                            'office_name' => 'Hınıs Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Horasan',
                            'office_code' => '25104',
                            'office_name' => 'Horasan Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'İspir',
                            'office_code' => '25105',
                            'office_name' => 'İspir Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Karayazı',
                            'office_code' => '25106',
                            'office_name' => 'Karayazı Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Narman',
                            'office_code' => '25107',
                            'office_name' => 'Narman Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Oltu',
                            'office_code' => '25108',
                            'office_name' => 'Oltu Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Olur',
                            'office_code' => '25109',
                            'office_name' => 'Olur Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Pasinler',
                            'office_code' => '25110',
                            'office_name' => 'Pasinler Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Şenkaya',
                            'office_code' => '25111',
                            'office_name' => 'Şenkaya Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Tekman',
                            'office_code' => '25112',
                            'office_name' => 'Tekman Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Tortum',
                            'office_code' => '25113',
                            'office_name' => 'Tortum Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Karaçoban',
                            'office_code' => '25114',
                            'office_name' => 'Karaçoban Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Uzundere',
                            'office_code' => '25115',
                            'office_name' => 'Uzundere Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Pazaryolu',
                            'office_code' => '25116',
                            'office_name' => 'Pazaryolu Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '25117 Aziziye (Ilıca) Malmüdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 25,
                            'city_name' => 'ERZURUM',
                            'town_name' => 'Köprüköy',
                            'office_code' => '25118',
                            'office_name' => 'Köprüköy Malmüdürlüğü',
                        ),
                ),
            26 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Merkez',
                            'office_code' => 'Başkanlık',
                            'office_name' => '26250 Eskişehir Vergi Dairesi Başkanlığı (*)',
                        ),
                    1 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Mahmudiye',
                            'office_code' => '26102',
                            'office_name' => 'Mahmudiye Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Mihalıççık',
                            'office_code' => '26103',
                            'office_name' => 'Mihalıççık Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Sarıcakaya',
                            'office_code' => '26104',
                            'office_name' => 'Sarıcakaya Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Seyitgazi',
                            'office_code' => '26105',
                            'office_name' => 'Seyitgazi Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Alpu',
                            'office_code' => '26107',
                            'office_name' => 'Alpu Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Beylikova',
                            'office_code' => '26108',
                            'office_name' => 'Beylikova Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'İnönü',
                            'office_code' => '26109',
                            'office_name' => 'İnönü Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Günyüzü',
                            'office_code' => '26110',
                            'office_name' => 'Günyüzü Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Han',
                            'office_code' => '26111',
                            'office_name' => 'Han Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 26,
                            'city_name' => 'ESKİŞEHİR',
                            'town_name' => 'Mihalgazi',
                            'office_code' => '26112',
                            'office_name' => 'Mihalgazi Malmüdürlüğü',
                        ),
                ),
            27 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Merkez',
                            'office_code' => '27250',
                            'office_name' => 'Gaziantep İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Merkez',
                            'office_code' => '27251',
                            'office_name' => 'Suburcu Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Merkez',
                            'office_code' => '27252',
                            'office_name' => 'Şehitkâmil Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Merkez',
                            'office_code' => '27253',
                            'office_name' => 'Şahinbey Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Merkez',
                            'office_code' => '27254',
                            'office_name' => 'Gazikent Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Merkez',
                            'office_code' => '27255',
                            'office_name' => 'Kozanlı Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Nizip',
                            'office_code' => '27202',
                            'office_name' => 'Nizip Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'İslahiye',
                            'office_code' => '27203',
                            'office_name' => 'İslahiye Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Araban',
                            'office_code' => '27101',
                            'office_name' => 'Araban Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '27105 Oğuzeli Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Yavuzeli',
                            'office_code' => '27106',
                            'office_name' => 'Yavuzeli Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Karkamış',
                            'office_code' => '27107',
                            'office_name' => 'Karkamış Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 27,
                            'city_name' => 'GAZİANTEP',
                            'town_name' => 'Nurdağı',
                            'office_code' => '27108',
                            'office_name' => 'Nurdağı Malmüdürlüğü',
                        ),
                ),
            28 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Merkez',
                            'office_code' => '28260',
                            'office_name' => 'Giresun Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Bulancak',
                            'office_code' => '28261',
                            'office_name' => 'Bulancak Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Alucra',
                            'office_code' => '28101',
                            'office_name' => 'Alucra Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Dereli',
                            'office_code' => '28103',
                            'office_name' => 'Dereli Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Espiye',
                            'office_code' => '28104',
                            'office_name' => 'Espiye Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Eynesil',
                            'office_code' => '28105',
                            'office_name' => 'Eynesil Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Görele',
                            'office_code' => '28106',
                            'office_name' => 'Görele Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Keşap',
                            'office_code' => '28107',
                            'office_name' => 'Keşap Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Şebinkarahisar',
                            'office_code' => '28108',
                            'office_name' => 'Şebinkarahisar Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Tirebolu',
                            'office_code' => '28109',
                            'office_name' => 'Tirebolu Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Piraziz',
                            'office_code' => '28110',
                            'office_name' => 'Piraziz Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Yağlıdere',
                            'office_code' => '28111',
                            'office_name' => 'Yağlıdere Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Çanakçı',
                            'office_code' => '28112',
                            'office_name' => 'Çanakçı Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Güce',
                            'office_code' => '28113',
                            'office_name' => 'Güce Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Çamoluk',
                            'office_code' => '28114',
                            'office_name' => 'Çamoluk Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 28,
                            'city_name' => 'GİRESUN',
                            'town_name' => 'Doğankent',
                            'office_code' => '28115',
                            'office_name' => 'Doğankent Malmüdürlüğü',
                        ),
                ),
            29 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 29,
                            'city_name' => 'GÜMÜŞHANE',
                            'town_name' => 'Merkez',
                            'office_code' => '29260',
                            'office_name' => 'Gümüşhane Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 29,
                            'city_name' => 'GÜMÜŞHANE',
                            'town_name' => 'Kelkit',
                            'office_code' => '29102',
                            'office_name' => 'Kelkit Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 29,
                            'city_name' => 'GÜMÜŞHANE',
                            'town_name' => 'Şiran',
                            'office_code' => '29103',
                            'office_name' => 'Şiran Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 29,
                            'city_name' => 'GÜMÜŞHANE',
                            'town_name' => 'Torul',
                            'office_code' => '29104',
                            'office_name' => 'Torul Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 29,
                            'city_name' => 'GÜMÜŞHANE',
                            'town_name' => 'Köse',
                            'office_code' => '29107',
                            'office_name' => 'Köse Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 29,
                            'city_name' => 'GÜMÜŞHANE',
                            'town_name' => 'Kürtün',
                            'office_code' => '29108',
                            'office_name' => 'Kürtün Malmüdürlüğü',
                        ),
                ),
            30 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 30,
                            'city_name' => 'HAKKARİ',
                            'town_name' => 'Merkez',
                            'office_code' => '30260',
                            'office_name' => 'Hakkari Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 30,
                            'city_name' => 'HAKKARİ',
                            'town_name' => 'Yüksekova',
                            'office_code' => '30261',
                            'office_name' => 'Yüksekova Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 30,
                            'city_name' => 'HAKKARİ',
                            'town_name' => 'Çukurca',
                            'office_code' => '30102',
                            'office_name' => 'Çukurca Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 30,
                            'city_name' => 'HAKKARİ',
                            'town_name' => 'Şemdinli',
                            'office_code' => '30103',
                            'office_name' => 'Şemdinli Malmüdürlüğü',
                        ),
                ),
            31 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Merkez',
                            'office_code' => '31201',
                            'office_name' => '23 Temmuz Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Merkez',
                            'office_code' => '31203',
                            'office_name' => 'Antakya Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Merkez',
                            'office_code' => '31280',
                            'office_name' => 'Şükrükanatlı Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'İskenderun',
                            'office_code' => '31202',
                            'office_name' => 'Sahil Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'İskenderun',
                            'office_code' => '31281',
                            'office_name' => 'Akdeniz Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'İskenderun',
                            'office_code' => '31290',
                            'office_name' => 'Asım Gündüz Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Dörtyol',
                            'office_code' => '31260',
                            'office_name' => 'Dörtyol Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Kırıkhan',
                            'office_code' => '31261',
                            'office_name' => 'Kırıkhan Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Reyhanlı',
                            'office_code' => '31262',
                            'office_name' => 'Reyhanlı Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Samandağ',
                            'office_code' => '31263',
                            'office_name' => 'Samandağ Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Altınözü',
                            'office_code' => '31101',
                            'office_name' => 'Altınözü Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Hassa',
                            'office_code' => '31103',
                            'office_name' => 'Hassa Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Yayladağı',
                            'office_code' => '31108',
                            'office_name' => 'Yayladağı Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Erzin',
                            'office_code' => '31109',
                            'office_name' => 'Erzin Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Belen',
                            'office_code' => '31110',
                            'office_name' => 'Belen Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 31,
                            'city_name' => 'HATAY',
                            'town_name' => 'Kumlu',
                            'office_code' => '31111',
                            'office_name' => 'Kumlu Malmüdürlüğü',
                        ),
                ),
            32 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Merkez',
                            'office_code' => '32201',
                            'office_name' => 'Davraz Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Merkez',
                            'office_code' => '32260',
                            'office_name' => 'Kaymakkapı Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Eğirdir',
                            'office_code' => '32261',
                            'office_name' => 'Eğirdir Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Yalvaç',
                            'office_code' => '32262',
                            'office_name' => 'Yalvaç Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Atabey',
                            'office_code' => '32101',
                            'office_name' => 'Atabey Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Gelendost',
                            'office_code' => '32103',
                            'office_name' => 'Gelendost Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Keçiborlu',
                            'office_code' => '32104',
                            'office_name' => 'Keçiborlu Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Senirkent',
                            'office_code' => '32105',
                            'office_name' => 'Senirkent Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Sütçüler',
                            'office_code' => '32106',
                            'office_name' => 'Sütçüler Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Şarkikaraağaç',
                            'office_code' => '32107',
                            'office_name' => 'Şarkikaraağaç Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Uluborlu',
                            'office_code' => '32108',
                            'office_name' => 'Uluborlu Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Aksu',
                            'office_code' => '32110',
                            'office_name' => 'Aksu Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Gönen',
                            'office_code' => '32111',
                            'office_name' => 'Gönen Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 32,
                            'city_name' => 'ISPARTA',
                            'town_name' => 'Yenişarbademli',
                            'office_code' => '32112',
                            'office_name' => 'Yenişarbademli Malmüdürlüğü',
                        ),
                ),
            33 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Merkez',
                            'office_code' => '33250',
                            'office_name' => 'İstiklâl Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Merkez',
                            'office_code' => '33252',
                            'office_name' => 'Uray Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Merkez',
                            'office_code' => '33254',
                            'office_name' => 'Liman Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Merkez',
                            'office_code' => '33255',
                            'office_name' => 'Toros Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Merkez',
                            'office_code' => '33256',
                            'office_name' => 'Mersin İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Erdemli',
                            'office_code' => '33201',
                            'office_name' => 'Erdemli Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Silifke',
                            'office_code' => '33202',
                            'office_name' => 'Silifke Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Anamur',
                            'office_code' => '33203',
                            'office_name' => 'Anamur Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Tarsus',
                            'office_code' => '33204',
                            'office_name' => 'Kızılmurat Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Tarsus',
                            'office_code' => '33205',
                            'office_name' => 'Şehitkerim Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Gülnar',
                            'office_code' => '33103',
                            'office_name' => 'Gülnar Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Mut',
                            'office_code' => '33104',
                            'office_name' => 'Mut Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Aydıncık',
                            'office_code' => '33107',
                            'office_name' => 'Aydıncık Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Bozyazı',
                            'office_code' => '33108',
                            'office_name' => 'Bozyazı Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 33,
                            'city_name' => 'MERSİN',
                            'town_name' => 'Çamlıyayla',
                            'office_code' => '33109',
                            'office_name' => 'Çamlıyayla Malmüdürlüğü',
                        ),
                ),
            34 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => 'Başkanlık',
                            'office_name' => '34230 Büyük Mükellefler Vergi Dairesi Başkanlığı (*)',
                        ),
                    1 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34231',
                            'office_name' => 'Boğaziçi Kurumlar Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34244',
                            'office_name' => 'Anadolu Kurumlar Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34232',
                            'office_name' => 'Marmara Kurumlar Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34220',
                            'office_name' => 'Haliç İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34221',
                            'office_name' => 'Vatan İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34222',
                            'office_name' => 'Çamlıca İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34223',
                            'office_name' => 'Alemdağ Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34266',
                            'office_name' => 'Beyoğlu Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34278',
                            'office_name' => 'Halkalı Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34234',
                            'office_name' => 'Davutpaşa Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34235',
                            'office_name' => 'Esenler Vergi Dairesi Müdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34236',
                            'office_name' => 'Fatih Vergi Dairesi Müdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34237',
                            'office_name' => 'Küçükköy Vergi Dairesi Müdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34239',
                            'office_name' => 'Merter Vergi Dairesi Müdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34242',
                            'office_name' => 'Sultanbeyli Vergi Dairesi Müdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34245',
                            'office_name' => 'Tuzla Vergi Dairesi Müdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34246',
                            'office_name' => 'Kozyatağı Vergi Dairesi Müdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34247',
                            'office_name' => 'Maslak Vergi Dairesi Müdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34248',
                            'office_name' => 'Zincirlikuyu Vergi Dairesi Müdürlüğü',
                        ),
                    20 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34249',
                            'office_name' => 'İkitelli Vergi Dairesi Müdürlüğü',
                        ),
                    21 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34251',
                            'office_name' => 'Beşiktaş Vergi Dairesi Müdürlüğü',
                        ),
                    22 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34252',
                            'office_name' => 'Ümraniye Vergi Dairesi Müdürlüğü',
                        ),
                    23 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34253',
                            'office_name' => 'Yeditepe Veraset ve Harçlar Vergi Dairesi Müdürlüğü',
                        ),
                    24 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34254',
                            'office_name' => 'Kasımpaşa Vergi Dairesi Müdürlüğü',
                        ),
                    25 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34255',
                            'office_name' => 'Erenköy Vergi Dairesi Müdürlüğü',
                        ),
                    26 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34256',
                            'office_name' => 'Hisar Veraset ve Harçlar Vergi Dairesi Müdürlüğü',
                        ),
                    27 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34257',
                            'office_name' => 'Tuna Vergi Dairesi Müdürlüğü',
                        ),
                    28 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34258',
                            'office_name' => 'Rıhtım Veraset ve Harçlar Vergi Dairesi Müdürlüğü',
                        ),
                    29 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34259',
                            'office_name' => 'Güngören Vergi Dairesi Müdürlüğü',
                        ),
                    30 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34260',
                            'office_name' => 'Kocasinan Vergi Dairesi Müdürlüğü',
                        ),
                    31 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34261',
                            'office_name' => 'Güneşli Vergi Dairesi Müdürlüğü',
                        ),
                    32 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34262',
                            'office_name' => 'Küçükyalı Vergi Dairesi Müdürlüğü',
                        ),
                    33 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34263',
                            'office_name' => 'Pendik Vergi Dairesi Müdürlüğü',
                        ),
                    34 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34264',
                            'office_name' => 'Bayrampaşa Vergi Dairesi Müdürlüğü',
                        ),
                    35 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34265',
                            'office_name' => 'Beyazıt Vergi Dairesi Müdürlüğü',
                        ),
                    36 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34269',
                            'office_name' => 'Gaziosmanpaşa Vergi Dairesi Müdürlüğü',
                        ),
                    37 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34270',
                            'office_name' => 'Göztepe Vergi Dairesi Müdürlüğü',
                        ),
                    38 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34271',
                            'office_name' => 'Hocapaşa Vergi Dairesi Müdürlüğü',
                        ),
                    39 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34272',
                            'office_name' => 'Kadıköy Vergi Dairesi Müdürlüğü',
                        ),
                    40 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34273',
                            'office_name' => 'Kocamustafapaşa Vergi Dairesi Müdürlüğü',
                        ),
                    41 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34274',
                            'office_name' => 'Mecidiyeköy Vergi Dairesi Müdürlüğü',
                        ),
                    42 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34276',
                            'office_name' => 'Şişli Vergi Dairesi Müdürlüğü',
                        ),
                    43 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34277',
                            'office_name' => 'Üsküdar Vergi Dairesi Müdürlüğü',
                        ),
                    44 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34279',
                            'office_name' => 'Kağıthane Vergi Dairesi Müdürlüğü',
                        ),
                    45 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34280',
                            'office_name' => 'Zeytinburnu Vergi Dairesi Müdürlüğü',
                        ),
                    46 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34281',
                            'office_name' => 'Beykoz Vergi Dairesi Müdürlüğü',
                        ),
                    47 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34283',
                            'office_name' => 'Sarıyer Vergi Dairesi Müdürlüğü',
                        ),
                    48 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34284',
                            'office_name' => 'Bakırköy Vergi Dairesi Müdürlüğü',
                        ),
                    49 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34285',
                            'office_name' => 'Kartal Vergi Dairesi Müdürlüğü',
                        ),
                    50 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34287',
                            'office_name' => 'Nakil Vasıtaları Vergi Dairesi Müdürlüğü',
                        ),
                    51 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34288',
                            'office_name' => 'Sarıgazi Vergi Dairesi Müdürlüğü',
                        ),
                    52 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34291',
                            'office_name' => 'Atışalanı Vergi Dairesi Müdürlüğü',
                        ),
                    53 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34292',
                            'office_name' => 'Yakacık Vergi Dairesi Müdürlüğü',
                        ),
                    54 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34293',
                            'office_name' => 'Yenibosna Vergi Dairesi Müdürlüğü',
                        ),
                    55 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34294',
                            'office_name' => 'Avcılar Vergi Dairesi Müdürlüğü',
                        ),
                    56 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34296',
                            'office_name' => 'Küçükçekmece Vergi Dairesi Müdürlüğü',
                        ),
                    57 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez',
                            'office_code' => '34297',
                            'office_name' => 'Beylikdüzü Vergi Dairesi Müdürlüğü',
                        ),
                    58 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '34295 Adalar Vergi Dairesi Müdürlüğü',
                        ),
                    59 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '34203 Silivri Vergi Dairesi Müdürlüğü',
                        ),
                    60 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '34204 Büyükçekmece Vergi Dairesi Müdürlüğü',
                        ),
                    61 =>
                        array(
                            'plate_no' => 34,
                            'city_name' => 'İSTANBUL',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '34205 Şile Vergi Dairesi Müdürlüğü',
                        ),
                ),
            35 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35264',
                            'office_name' => 'Bornova Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35265',
                            'office_name' => 'Çakabey Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35259',
                            'office_name' => 'Kordon Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35263',
                            'office_name' => 'Hasan Tahsin Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35250',
                            'office_name' => 'İzmir İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35251',
                            'office_name' => '9 Eylül Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35252',
                            'office_name' => 'Yamanlar Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35256',
                            'office_name' => 'Karşıyaka Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35257',
                            'office_name' => 'Kemeraltı Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35258',
                            'office_name' => 'Konak Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35260',
                            'office_name' => 'Şirinyer Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35261',
                            'office_name' => 'Kadifekale Vergi Dairesi Müdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35262',
                            'office_name' => 'Taşıtlar Vergi Dairesi Müdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35254',
                            'office_name' => 'Belkahve Vergi Dairesi Müdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35266',
                            'office_name' => 'Balçova Vergi Dairesi Müdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35267',
                            'office_name' => 'Gaziemir Vergi Dairesi Müdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35268',
                            'office_name' => 'Ege Vergi Dairesi Müdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez',
                            'office_code' => '35269',
                            'office_name' => 'Çiğli Vergi Dairesi Müdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Bayındır',
                            'office_code' => '35201',
                            'office_name' => 'Bayındır Vergi Dairesi Müdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Bergama',
                            'office_code' => '35202',
                            'office_name' => 'Bergama Vergi Dairesi Müdürlüğü',
                        ),
                    20 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '35203 Menemen Vergi Dairesi Müdürlüğü',
                        ),
                    21 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Ödemiş',
                            'office_code' => '35204',
                            'office_name' => 'Ödemiş Vergi Dairesi Müdürlüğü',
                        ),
                    22 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Tire',
                            'office_code' => '35205',
                            'office_name' => 'Tire Vergi Dairesi Müdürlüğü',
                        ),
                    23 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '35206 Torbalı Vergi Dairesi Müdürlüğü',
                        ),
                    24 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '35207 Kemalpaşa Vergi Dairesi Müdürlüğü',
                        ),
                    25 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '35208 Urla Vergi Dairesi Müdürlüğü',
                        ),
                    26 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Selçuk',
                            'office_code' => '35209',
                            'office_name' => 'Selçuk Vergi Dairesi Müdürlüğü',
                        ),
                    27 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Kınık',
                            'office_code' => '35210',
                            'office_name' => 'Kınık Vergi Dairesi Müdürlüğü',
                        ),
                    28 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Kiraz',
                            'office_code' => '35211',
                            'office_name' => 'Kiraz Vergi Dairesi Müdürlüğü',
                        ),
                    29 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Çeşme',
                            'office_code' => '35212',
                            'office_name' => 'Çeşme Vergi Dairesi Müdürlüğü',
                        ),
                    30 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '35213 Aliağa Vergi Dairesi Müdürlüğü',
                        ),
                    31 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '35215 Menderes Vergi Dairesi Müdürlüğü',
                        ),
                    32 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Dikili',
                            'office_code' => '35105',
                            'office_name' => 'Dikili Malmüdürlüğü',
                        ),
                    33 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '35106 Foça Malmüdürlüğü',
                        ),
                    34 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Karaburun',
                            'office_code' => '35107',
                            'office_name' => 'Karaburun Malmüdürlüğü',
                        ),
                    35 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '35114 Seferihisar Malmüdürlüğü',
                        ),
                    36 =>
                        array(
                            'plate_no' => 35,
                            'city_name' => 'İZMİR',
                            'town_name' => 'Beydağ',
                            'office_code' => '35120',
                            'office_name' => 'Beydağ Malmüdürlüğü',
                        ),
                ),
            36 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 36,
                            'city_name' => 'KARS',
                            'town_name' => 'Merkez',
                            'office_code' => '36260',
                            'office_name' => 'Kars Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 36,
                            'city_name' => 'KARS',
                            'town_name' => 'Arpaçay',
                            'office_code' => '36103',
                            'office_name' => 'Arpaçay Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 36,
                            'city_name' => 'KARS',
                            'town_name' => 'Digor',
                            'office_code' => '36105',
                            'office_name' => 'Digor Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 36,
                            'city_name' => 'KARS',
                            'town_name' => 'Kağızman',
                            'office_code' => '36109',
                            'office_name' => 'Kağızman Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 36,
                            'city_name' => 'KARS',
                            'town_name' => 'Sarıkamış',
                            'office_code' => '36111',
                            'office_name' => 'Sarıkamış Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 36,
                            'city_name' => 'KARS',
                            'town_name' => 'Selim',
                            'office_code' => '36112',
                            'office_name' => 'Selim Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 36,
                            'city_name' => 'KARS',
                            'town_name' => 'Susuz',
                            'office_code' => '36113',
                            'office_name' => 'Susuz Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 36,
                            'city_name' => 'KARS',
                            'town_name' => 'Akyaka',
                            'office_code' => '36115',
                            'office_name' => 'Akyaka Malmüdürlüğü',
                        ),
                ),
            37 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Merkez',
                            'office_code' => '37260',
                            'office_name' => 'Kastamonu Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Tosya',
                            'office_code' => '37261',
                            'office_name' => 'Tosya Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Taşköprü',
                            'office_code' => '37262',
                            'office_name' => 'Taşköprü Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Araç',
                            'office_code' => '37101',
                            'office_name' => 'Araç Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Azdavay',
                            'office_code' => '37102',
                            'office_name' => 'Azdavay Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Bozkurt',
                            'office_code' => '37103',
                            'office_name' => 'Bozkurt Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Cide',
                            'office_code' => '37104',
                            'office_name' => 'Cide Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Çatalzeytin',
                            'office_code' => '37105',
                            'office_name' => 'Çatalzeytin Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Daday',
                            'office_code' => '37106',
                            'office_name' => 'Daday Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Devrekani',
                            'office_code' => '37107',
                            'office_name' => 'Devrekani Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'İnebolu',
                            'office_code' => '37108',
                            'office_name' => 'İnebolu Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Küre',
                            'office_code' => '37109',
                            'office_name' => 'Küre Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Abana',
                            'office_code' => '37112',
                            'office_name' => 'Abana Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'İhsangazi',
                            'office_code' => '37113',
                            'office_name' => 'İhsangazi Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Pınarbaşı',
                            'office_code' => '37114',
                            'office_name' => 'Pınarbaşı Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Şenpazar',
                            'office_code' => '37115',
                            'office_name' => 'Şenpazar Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Ağlı',
                            'office_code' => '37116',
                            'office_name' => 'Ağlı Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Doğanyurt',
                            'office_code' => '37117',
                            'office_name' => 'Doğanyurt Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Hanönü',
                            'office_code' => '37118',
                            'office_name' => 'Hanönü Malmüdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 37,
                            'city_name' => 'KASTAMONU',
                            'town_name' => 'Seydiler',
                            'office_code' => '37119',
                            'office_name' => 'Seydiler Malmüdürlüğü',
                        ),
                ),
            38 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Merkez',
                            'office_code' => '38250',
                            'office_name' => 'Kayseri İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Merkez',
                            'office_code' => '38251',
                            'office_name' => 'Mimar Sinan Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Merkez',
                            'office_code' => '38252',
                            'office_name' => 'Erciyes Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Merkez',
                            'office_code' => '38253',
                            'office_name' => 'Kaleönü Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Merkez',
                            'office_code' => '38254',
                            'office_name' => 'Gevher Nesibe Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Develi',
                            'office_code' => '38201',
                            'office_name' => 'Develi Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Pınarbaşı',
                            'office_code' => '38202',
                            'office_name' => 'Pınarbaşı Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Bünyan',
                            'office_code' => '38203',
                            'office_name' => 'Bünyan Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Felahiye',
                            'office_code' => '38103',
                            'office_name' => 'Felahiye Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'İncesu',
                            'office_code' => '38104',
                            'office_name' => 'İncesu Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Sarıoğlan',
                            'office_code' => '38106',
                            'office_name' => 'Sarıoğlan Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Sarız',
                            'office_code' => '38107',
                            'office_name' => 'Sarız Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Tomarza',
                            'office_code' => '38108',
                            'office_name' => 'Tomarza Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Yahyalı',
                            'office_code' => '38109',
                            'office_name' => 'Yahyalı Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Yeşilhisar',
                            'office_code' => '38110',
                            'office_name' => 'Yeşilhisar Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Akkışla',
                            'office_code' => '38111',
                            'office_name' => 'Akkışla Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '38113 Hacılar Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 38,
                            'city_name' => 'KAYSERİ',
                            'town_name' => 'Özvatan',
                            'office_code' => '38114',
                            'office_name' => 'Özvatan Malmüdürlüğü',
                        ),
                ),
            39 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 39,
                            'city_name' => 'KIRKLARELİ',
                            'town_name' => 'Merkez',
                            'office_code' => '39260',
                            'office_name' => 'Kırklareli Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 39,
                            'city_name' => 'KIRKLARELİ',
                            'town_name' => 'Lüleburgaz',
                            'office_code' => '39261',
                            'office_name' => 'Lüleburgaz Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 39,
                            'city_name' => 'KIRKLARELİ',
                            'town_name' => 'Babaeski',
                            'office_code' => '39262',
                            'office_name' => 'Babaeski Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 39,
                            'city_name' => 'KIRKLARELİ',
                            'town_name' => 'Demirköy',
                            'office_code' => '39102',
                            'office_name' => 'Demirköy Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 39,
                            'city_name' => 'KIRKLARELİ',
                            'town_name' => 'Kofçaz',
                            'office_code' => '39103',
                            'office_name' => 'Kofçaz Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 39,
                            'city_name' => 'KIRKLARELİ',
                            'town_name' => 'Pehlivanköy',
                            'office_code' => '39105',
                            'office_name' => 'Pehlivanköy Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 39,
                            'city_name' => 'KIRKLARELİ',
                            'town_name' => 'Pınarhisar',
                            'office_code' => '39106',
                            'office_name' => 'Pınarhisar Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 39,
                            'city_name' => 'KIRKLARELİ',
                            'town_name' => 'Vize',
                            'office_code' => '39107',
                            'office_name' => 'Vize Malmüdürlüğü',
                        ),
                ),
            40 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 40,
                            'city_name' => 'KIRŞEHİR',
                            'town_name' => 'Merkez',
                            'office_code' => '40260',
                            'office_name' => 'Kırşehir Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 40,
                            'city_name' => 'KIRŞEHİR',
                            'town_name' => 'Kaman',
                            'office_code' => '40261',
                            'office_name' => 'Kaman Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 40,
                            'city_name' => 'KIRŞEHİR',
                            'town_name' => 'Çiçekdağı',
                            'office_code' => '40101',
                            'office_name' => 'Çiçekdağı Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 40,
                            'city_name' => 'KIRŞEHİR',
                            'town_name' => 'Mucur',
                            'office_code' => '40103',
                            'office_name' => 'Mucur Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 40,
                            'city_name' => 'KIRŞEHİR',
                            'town_name' => 'Akpınar',
                            'office_code' => '40104',
                            'office_name' => 'Akpınar Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 40,
                            'city_name' => 'KIRŞEHİR',
                            'town_name' => 'Akçakent',
                            'office_code' => '40105',
                            'office_name' => 'Akçakent Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 40,
                            'city_name' => 'KIRŞEHİR',
                            'town_name' => 'Boztepe',
                            'office_code' => '40106',
                            'office_name' => 'Boztepe Malmüdürlüğü',
                        ),
                ),
            41 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez',
                            'office_code' => '41250',
                            'office_name' => 'Kocaeli İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez',
                            'office_code' => '41252',
                            'office_name' => 'Tepecik Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez',
                            'office_code' => '41253',
                            'office_name' => 'Alemdar Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez',
                            'office_code' => 'Gebze',
                            'office_name' => '41254 Gebze İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez',
                            'office_code' => '41290',
                            'office_name' => 'Acısu Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '41202 Uluçınar Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '41203 İlyasbey Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '41204 Gölcük Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '41205 Karamürsel Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '41206 Körfez Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '41207 Derince Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 41,
                            'city_name' => 'KOCAELİ',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '41103 Kandıra Malmüdürlüğü',
                        ),
                ),
            42 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Merkez',
                            'office_code' => '42250',
                            'office_name' => 'Konya İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Merkez',
                            'office_code' => '42251',
                            'office_name' => 'Selçuk Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Merkez',
                            'office_code' => '42252',
                            'office_name' => 'Mevlana Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Merkez',
                            'office_code' => '42253',
                            'office_name' => 'Meram Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Merkez',
                            'office_code' => '42254',
                            'office_name' => 'Alaaddin Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Akşehir',
                            'office_code' => '42201',
                            'office_name' => 'Akşehir Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Ereğli',
                            'office_code' => '42202',
                            'office_name' => 'Ereğli Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Beyşehir',
                            'office_code' => '42204',
                            'office_name' => 'Beyşehir Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Cihanbeyli',
                            'office_code' => '42205',
                            'office_name' => 'Cihanbeyli Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Çumra',
                            'office_code' => '42206',
                            'office_name' => 'Çumra Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Seydişehir',
                            'office_code' => '42207',
                            'office_name' => 'Seydişehir Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Ilgın',
                            'office_code' => '42208',
                            'office_name' => 'Ilgın Vergi Dairesi Müdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Kulu',
                            'office_code' => '42209',
                            'office_name' => 'Kulu Vergi Dairesi Müdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Karapınar',
                            'office_code' => '42210',
                            'office_name' => 'Karapınar Vergi Dairesi Müdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Bozkır',
                            'office_code' => '42103',
                            'office_name' => 'Bozkır Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Doğanhisar',
                            'office_code' => '42106',
                            'office_name' => 'Doğanhisar Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Hadim',
                            'office_code' => '42109',
                            'office_name' => 'Hadim Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Kadınhanı',
                            'office_code' => '42111',
                            'office_name' => 'Kadınhanı Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Sarayönü',
                            'office_code' => '42115',
                            'office_name' => 'Sarayönü Malmüdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Yunak',
                            'office_code' => '42117',
                            'office_name' => 'Yunak Malmüdürlüğü',
                        ),
                    20 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Akören',
                            'office_code' => '42118',
                            'office_name' => 'Akören Malmüdürlüğü',
                        ),
                    21 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Altınekin',
                            'office_code' => '42119',
                            'office_name' => 'Altınekin Malmüdürlüğü',
                        ),
                    22 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Derebucak',
                            'office_code' => '42121',
                            'office_name' => 'Derebucak Malmüdürlüğü',
                        ),
                    23 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Hüyük',
                            'office_code' => '42122',
                            'office_name' => 'Hüyük Malmüdürlüğü',
                        ),
                    24 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Taşkent',
                            'office_code' => '42123',
                            'office_name' => 'Taşkent Malmüdürlüğü',
                        ),
                    25 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Emirgazi',
                            'office_code' => '42127',
                            'office_name' => 'Emirgazi Malmüdürlüğü',
                        ),
                    26 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Güneysınır',
                            'office_code' => '42128',
                            'office_name' => 'Güneysınır Malmüdürlüğü',
                        ),
                    27 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Halkapınar',
                            'office_code' => '42129',
                            'office_name' => 'Halkapınar Malmüdürlüğü',
                        ),
                    28 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Tuzlukçu',
                            'office_code' => '42130',
                            'office_name' => 'Tuzlukçu Malmüdürlüğü',
                        ),
                    29 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Ahırlı',
                            'office_code' => '42124',
                            'office_name' => 'Ahırlı Malmüdürlüğü',
                        ),
                    30 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Çeltik',
                            'office_code' => '42125',
                            'office_name' => 'Çeltik Malmüdürlüğü',
                        ),
                    31 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Derbent',
                            'office_code' => '42126',
                            'office_name' => 'Derbent Malmüdürlüğü',
                        ),
                    32 =>
                        array(
                            'plate_no' => 42,
                            'city_name' => 'KONYA',
                            'town_name' => 'Yalıhüyük',
                            'office_code' => '42131',
                            'office_name' => 'Yalıhüyük Malmüdürlüğü',
                        ),
                ),
            43 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Merkez',
                            'office_code' => '43201',
                            'office_name' => '30 Ağustos Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Merkez',
                            'office_code' => '43280',
                            'office_name' => 'Çinili Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Gediz',
                            'office_code' => '43260',
                            'office_name' => 'Gediz Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Simav',
                            'office_code' => '43261',
                            'office_name' => 'Simav Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Tavşanlı',
                            'office_code' => '43262',
                            'office_name' => 'Tavşanlı Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Emet',
                            'office_code' => '43263',
                            'office_name' => 'Emet Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Altıntaş',
                            'office_code' => '43101',
                            'office_name' => 'Altıntaş Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Domaniç',
                            'office_code' => '43102',
                            'office_name' => 'Domaniç Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Aslanapa',
                            'office_code' => '43107',
                            'office_name' => 'Aslanapa Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Dumlupınar',
                            'office_code' => '43108',
                            'office_name' => 'Dumlupınar Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Hisarcık',
                            'office_code' => '43109',
                            'office_name' => 'Hisarcık Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Şaphane',
                            'office_code' => '43110',
                            'office_name' => 'Şaphane Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Çavdarhisar',
                            'office_code' => '43111',
                            'office_name' => 'Çavdarhisar Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 43,
                            'city_name' => 'KÜTAHYA',
                            'town_name' => 'Pazarlar',
                            'office_code' => '43112',
                            'office_name' => 'Pazarlar Malmüdürlüğü',
                        ),
                ),
            44 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Merkez',
                            'office_code' => '44251',
                            'office_name' => 'Fırat Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Merkez',
                            'office_code' => '44252',
                            'office_name' => 'Beydağı Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Akçadağ',
                            'office_code' => '44101',
                            'office_name' => 'Akçadağ Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Arapgir',
                            'office_code' => '44102',
                            'office_name' => 'Arapgir Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Arguvan',
                            'office_code' => '44103',
                            'office_name' => 'Arguvan Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Darende',
                            'office_code' => '44104',
                            'office_name' => 'Darende Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Doğanşehir',
                            'office_code' => '44105',
                            'office_name' => 'Doğanşehir Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Hekimhan',
                            'office_code' => '44106',
                            'office_name' => 'Hekimhan Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Pütürge',
                            'office_code' => '44107',
                            'office_name' => 'Pütürge Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Yeşilyurt',
                            'office_code' => '44108',
                            'office_name' => 'Yeşilyurt Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Battalgazi',
                            'office_code' => '44109',
                            'office_name' => 'Battalgazi Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Doğanyol',
                            'office_code' => '44110',
                            'office_name' => 'Doğanyol Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Kale',
                            'office_code' => '44111',
                            'office_name' => 'Kale Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Kuluncak',
                            'office_code' => '44112',
                            'office_name' => 'Kuluncak Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 44,
                            'city_name' => 'MALATYA',
                            'town_name' => 'Yazıhan',
                            'office_code' => '44113',
                            'office_name' => 'Yazıhan Malmüdürlüğü',
                        ),
                ),
            45 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Merkez',
                            'office_code' => '45250',
                            'office_name' => 'Manisa İhtisas Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Merkez',
                            'office_code' => '45251',
                            'office_name' => 'Alaybey Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Merkez',
                            'office_code' => '45252',
                            'office_name' => 'Mesir Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Akhisar',
                            'office_code' => '45201',
                            'office_name' => 'Akhisar Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Alaşehir',
                            'office_code' => '45202',
                            'office_name' => 'Alaşehir Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Demirci',
                            'office_code' => '45203',
                            'office_name' => 'Demirci Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Kırkağaç',
                            'office_code' => '45204',
                            'office_name' => 'Kırkağaç Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Salihli',
                            'office_code' => '45205',
                            'office_name' => 'Salihli Adil Oral Vergi Dairesi Müdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Sarıgöl',
                            'office_code' => '45206',
                            'office_name' => 'Sarıgöl Vergi Dairesi Müdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Saruhanlı',
                            'office_code' => '45207',
                            'office_name' => 'Saruhanlı Vergi Dairesi Müdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Soma',
                            'office_code' => '45208',
                            'office_name' => 'Soma Vergi Dairesi Müdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Turgutlu',
                            'office_code' => '45209',
                            'office_name' => 'Turgutlu Vergi Dairesi Müdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Gördes',
                            'office_code' => '45210',
                            'office_name' => 'Gördes Vergi Dairesi Müdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Kula',
                            'office_code' => '45211',
                            'office_name' => 'Kula Vergi Dairesi Müdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Selendi',
                            'office_code' => '45110',
                            'office_name' => 'Selendi Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Ahmetli',
                            'office_code' => '45113',
                            'office_name' => 'Ahmetli Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Gölmarmara',
                            'office_code' => '45114',
                            'office_name' => 'Gölmarmara Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 45,
                            'city_name' => 'MANİSA',
                            'town_name' => 'Köprübaşı',
                            'office_code' => '45115',
                            'office_name' => 'Köprübaşı Malmüdürlüğü',
                        ),
                ),
            46 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Merkez',
                            'office_code' => '46201',
                            'office_name' => 'Aslanbey Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Merkez',
                            'office_code' => '46280',
                            'office_name' => 'Aksu Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Elbistan',
                            'office_code' => '46260',
                            'office_name' => 'Elbistan Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Afşin',
                            'office_code' => '46261',
                            'office_name' => 'Afşin Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Pazarcık',
                            'office_code' => '46262',
                            'office_name' => 'Pazarcık Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Andırın',
                            'office_code' => '46102',
                            'office_name' => 'Andırın Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Göksun',
                            'office_code' => '46104',
                            'office_name' => 'Göksun Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Türkoğlu',
                            'office_code' => '46106',
                            'office_name' => 'Türkoğlu Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Çağlayancerit',
                            'office_code' => '46107',
                            'office_name' => 'Çağlayancerit Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Ekinözü',
                            'office_code' => '46108',
                            'office_name' => 'Ekinözü Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 46,
                            'city_name' => 'KAHRAMANMARAŞ',
                            'town_name' => 'Nurhak',
                            'office_code' => '46109',
                            'office_name' => 'Nurhak Malmüdürlüğü',
                        ),
                ),
            47 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Merkez',
                            'office_code' => '47260',
                            'office_name' => 'Mardin Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Kızıltepe',
                            'office_code' => '47261',
                            'office_name' => 'Kızıltepe Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Nusaybin',
                            'office_code' => '47262',
                            'office_name' => 'Nusaybin Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Derik',
                            'office_code' => '47102',
                            'office_name' => 'Derik Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Mazıdağı',
                            'office_code' => '47106',
                            'office_name' => 'Mazıdağı Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Midyat',
                            'office_code' => '47107',
                            'office_name' => 'Midyat Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Ömerli',
                            'office_code' => '47109',
                            'office_name' => 'Ömerli Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Savur',
                            'office_code' => '47110',
                            'office_name' => 'Savur Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Dargeçit',
                            'office_code' => '47112',
                            'office_name' => 'Dargeçit Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 47,
                            'city_name' => 'MARDİN',
                            'town_name' => 'Yeşilli',
                            'office_code' => '47113',
                            'office_name' => 'Yeşilli Malmüdürlüğü',
                        ),
                ),
            48 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Merkez',
                            'office_code' => '48260',
                            'office_name' => 'Muğla Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Bodrum',
                            'office_code' => '48261',
                            'office_name' => 'Bodrum Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Fethiye',
                            'office_code' => '48262',
                            'office_name' => 'Fethiye Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Köyceğiz',
                            'office_code' => '48263',
                            'office_name' => 'Köyceğiz Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Milas',
                            'office_code' => '48264',
                            'office_name' => 'Milas Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Marmaris',
                            'office_code' => '48265',
                            'office_name' => 'Marmaris Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Yatağan',
                            'office_code' => '48266',
                            'office_name' => 'Yatağan Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Datça',
                            'office_code' => '48102',
                            'office_name' => 'Datça Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Ula',
                            'office_code' => '48108',
                            'office_name' => 'Ula Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Dalaman',
                            'office_code' => '48109',
                            'office_name' => 'Dalaman Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Ortaca',
                            'office_code' => '48110',
                            'office_name' => 'Ortaca Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Kavaklıdere',
                            'office_code' => '48111',
                            'office_name' => 'Kavaklıdere Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 48,
                            'city_name' => 'MUĞLA',
                            'town_name' => 'Seydiemer',
                            'office_code' => '48113',
                            'office_name' => 'Seydikemer Malmüdürlüğü',
                        ),
                ),
            49 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 49,
                            'city_name' => 'MUŞ',
                            'town_name' => 'Merkez',
                            'office_code' => '49260',
                            'office_name' => 'Muş Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 49,
                            'city_name' => 'MUŞ',
                            'town_name' => 'Bulanık',
                            'office_code' => '49101',
                            'office_name' => 'Bulanık Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 49,
                            'city_name' => 'MUŞ',
                            'town_name' => 'Malazgirt',
                            'office_code' => '49102',
                            'office_name' => 'Malazgirt Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 49,
                            'city_name' => 'MUŞ',
                            'town_name' => 'Varto',
                            'office_code' => '49103',
                            'office_name' => 'Varto Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 49,
                            'city_name' => 'MUŞ',
                            'town_name' => 'Hasköy',
                            'office_code' => '49104',
                            'office_name' => 'Hasköy Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 49,
                            'city_name' => 'MUŞ',
                            'town_name' => 'Korkut',
                            'office_code' => '49105',
                            'office_name' => 'Korkut Malmüdürlüğü',
                        ),
                ),
            50 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 50,
                            'city_name' => 'NEVŞEHİR',
                            'town_name' => 'Merkez',
                            'office_code' => '50260',
                            'office_name' => 'Nevşehir Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 50,
                            'city_name' => 'NEVŞEHİR',
                            'town_name' => 'Avanos',
                            'office_code' => '50101',
                            'office_name' => 'Avanos Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 50,
                            'city_name' => 'NEVŞEHİR',
                            'town_name' => 'Derinkuyu',
                            'office_code' => '50102',
                            'office_name' => 'Derinkuyu Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 50,
                            'city_name' => 'NEVŞEHİR',
                            'town_name' => 'Gülşehir',
                            'office_code' => '50103',
                            'office_name' => 'Gülşehir Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 50,
                            'city_name' => 'NEVŞEHİR',
                            'town_name' => 'Hacıbektaş',
                            'office_code' => '50104',
                            'office_name' => 'Hacıbektaş Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 50,
                            'city_name' => 'NEVŞEHİR',
                            'town_name' => 'Kozaklı',
                            'office_code' => '50105',
                            'office_name' => 'Kozaklı Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 50,
                            'city_name' => 'NEVŞEHİR',
                            'town_name' => 'Ürgüp',
                            'office_code' => '50106',
                            'office_name' => 'Ürgüp Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 50,
                            'city_name' => 'NEVŞEHİR',
                            'town_name' => 'Acıgöl',
                            'office_code' => '50107',
                            'office_name' => 'Acıgöl Malmüdürlüğü',
                        ),
                ),
            51 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 51,
                            'city_name' => 'NİĞDE',
                            'town_name' => 'Merkez',
                            'office_code' => '51260',
                            'office_name' => 'Niğde Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 51,
                            'city_name' => 'NİĞDE',
                            'town_name' => 'Bor',
                            'office_code' => '51262',
                            'office_name' => 'Bor Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 51,
                            'city_name' => 'NİĞDE',
                            'town_name' => 'Çamardı',
                            'office_code' => '51103',
                            'office_name' => 'Çamardı Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 51,
                            'city_name' => 'NİĞDE',
                            'town_name' => 'Ulukışla',
                            'office_code' => '51105',
                            'office_name' => 'Ulukışla Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 51,
                            'city_name' => 'NİĞDE',
                            'town_name' => 'Altunhisar',
                            'office_code' => '51106',
                            'office_name' => 'Altunhisar Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 51,
                            'city_name' => 'NİĞDE',
                            'town_name' => 'Çiftlik',
                            'office_code' => '51107',
                            'office_name' => 'Çiftlik Malmüdürlüğü',
                        ),
                ),
            52 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Merkez',
                            'office_code' => '52201',
                            'office_name' => 'Boztepe Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Merkez',
                            'office_code' => '52260',
                            'office_name' => 'Köprübaşı Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Fatsa',
                            'office_code' => '52261',
                            'office_name' => 'Fatsa Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Ünye',
                            'office_code' => '52262',
                            'office_name' => 'Ünye Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Akkuş',
                            'office_code' => '52101',
                            'office_name' => 'Akkuş Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Aybastı',
                            'office_code' => '52102',
                            'office_name' => 'Aybastı Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Gölköy',
                            'office_code' => '52104',
                            'office_name' => 'Gölköy Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Korgan',
                            'office_code' => '52105',
                            'office_name' => 'Korgan Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Kumru',
                            'office_code' => '52106',
                            'office_name' => 'Kumru Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Mesudiye',
                            'office_code' => '52107',
                            'office_name' => 'Mesudiye Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Perşembe',
                            'office_code' => '52108',
                            'office_name' => 'Perşembe Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Ulubey',
                            'office_code' => '52109',
                            'office_name' => 'Ulubey Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Gülyalı',
                            'office_code' => '52111',
                            'office_name' => 'Gülyalı Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Gürgentepe',
                            'office_code' => '52112',
                            'office_name' => 'Gürgentepe Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Çamaş',
                            'office_code' => '52113',
                            'office_name' => 'Çamaş Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Çatalpınar',
                            'office_code' => '52114',
                            'office_name' => 'Çatalpınar Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Çaybaşı',
                            'office_code' => '52115',
                            'office_name' => 'Çaybaşı Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'İkizce',
                            'office_code' => '52116',
                            'office_name' => 'İkizce Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Kabadüz',
                            'office_code' => '52117',
                            'office_name' => 'Kabadüz Malmüdürlüğü',
                        ),
                    19 =>
                        array(
                            'plate_no' => 52,
                            'city_name' => 'ORDU',
                            'town_name' => 'Kabataş',
                            'office_code' => '52118',
                            'office_name' => 'Kabataş Malmüdürlüğü',
                        ),
                ),
            53 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Merkez',
                            'office_code' => '53201',
                            'office_name' => 'Kaçkar Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Merkez',
                            'office_code' => '53260',
                            'office_name' => 'Yeşilçay Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Çayeli',
                            'office_code' => '53261',
                            'office_name' => 'Çayeli Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Pazar',
                            'office_code' => '53262',
                            'office_name' => 'Pazar Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Ardeşen',
                            'office_code' => '53263',
                            'office_name' => 'Ardeşen Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Çamlıhemşin',
                            'office_code' => '53102',
                            'office_name' => 'Çamlıhemşin Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Fındıklı',
                            'office_code' => '53104',
                            'office_name' => 'Fındıklı Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'İkizdere',
                            'office_code' => '53105',
                            'office_name' => 'İkizdere Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Kalkandere',
                            'office_code' => '53106',
                            'office_name' => 'Kalkandere Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Güneysu',
                            'office_code' => '53108',
                            'office_name' => 'Güneysu Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Derepazarı',
                            'office_code' => '53109',
                            'office_name' => 'Derepazarı Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'Hemşin',
                            'office_code' => '53110',
                            'office_name' => 'Hemşin Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 53,
                            'city_name' => 'RİZE',
                            'town_name' => 'İyidere',
                            'office_code' => '53111',
                            'office_name' => 'İyidere Malmüdürlüğü',
                        ),
                ),
            54 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Merkez',
                            'office_code' => '54251',
                            'office_name' => 'Gümrükönü Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Merkez',
                            'office_code' => '54252',
                            'office_name' => 'Ali Fuat Cebesoy Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '54253 Sapanca Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '54201 Akyazı Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Geyve',
                            'office_code' => '54202',
                            'office_name' => 'Geyve Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '54203 Hendek Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Karasu',
                            'office_code' => '54204',
                            'office_name' => 'Karasu Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Kaynarca',
                            'office_code' => '54105',
                            'office_name' => 'Kaynarca Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Kocaali',
                            'office_code' => '54107',
                            'office_name' => 'Kocaali Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Pamukova',
                            'office_code' => '54108',
                            'office_name' => 'Pamukova Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Taraklı',
                            'office_code' => '54109',
                            'office_name' => 'Taraklı Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 54,
                            'city_name' => 'SAKARYA',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '54111 Karapürçek Malmüdürlüğü',
                        ),
                ),
            55 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Merkez',
                            'office_code' => '55251',
                            'office_name' => '19 Mayıs Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Merkez',
                            'office_code' => '55252',
                            'office_name' => 'Gaziler Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Merkez',
                            'office_code' => '55290',
                            'office_name' => 'Zafer Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Bafra',
                            'office_code' => '55202',
                            'office_name' => 'Bafra Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Çarşamba',
                            'office_code' => '55203',
                            'office_name' => 'Çarşamba Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Terme',
                            'office_code' => '55204',
                            'office_name' => 'Terme Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Havza',
                            'office_code' => '55205',
                            'office_name' => 'Havza Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Alaçam',
                            'office_code' => '55101',
                            'office_name' => 'Alaçam Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Kavak',
                            'office_code' => '55105',
                            'office_name' => 'Kavak Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Ladik',
                            'office_code' => '55106',
                            'office_name' => 'Ladik Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Vezirköprü',
                            'office_code' => '55108',
                            'office_name' => 'Vezirköprü Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Asarcık',
                            'office_code' => '55109',
                            'office_name' => 'Asarcık Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Ondokuz',
                            'office_code' => 'Mayıs',
                            'office_name' => '55110 Ondokuz Mayıs Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Salıpazarı',
                            'office_code' => '55111',
                            'office_name' => 'Salıpazarı Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Merkez-',
                            'office_code' => '(5216)',
                            'office_name' => '55112 Tekkeköy Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Ayvacık',
                            'office_code' => '55113',
                            'office_name' => 'Ayvacık Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 55,
                            'city_name' => 'SAMSUN',
                            'town_name' => 'Yakakent',
                            'office_code' => '55114',
                            'office_name' => 'Yakakent Malmüdürlüğü',
                        ),
                ),
            56 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 56,
                            'city_name' => 'SİİRT',
                            'town_name' => 'Merkez',
                            'office_code' => '56260',
                            'office_name' => 'Siirt Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 56,
                            'city_name' => 'SİİRT',
                            'town_name' => 'Baykan',
                            'office_code' => '56102',
                            'office_name' => 'Baykan Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 56,
                            'city_name' => 'SİİRT',
                            'town_name' => 'Eruh',
                            'office_code' => '56104',
                            'office_name' => 'Eruh Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 56,
                            'city_name' => 'SİİRT',
                            'town_name' => 'Kurtalan',
                            'office_code' => '56106',
                            'office_name' => 'Kurtalan Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 56,
                            'city_name' => 'SİİRT',
                            'town_name' => 'Pervari',
                            'office_code' => '56107',
                            'office_name' => 'Pervari Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 56,
                            'city_name' => 'SİİRT',
                            'town_name' => 'Şirvan',
                            'office_code' => '56110',
                            'office_name' => 'Şirvan Malmüdürlüğü',
                        ),
                ),
            57 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Merkez',
                            'office_code' => '57260',
                            'office_name' => 'Sinop Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Boyabat',
                            'office_code' => '57261',
                            'office_name' => 'Boyabat Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Ayancık',
                            'office_code' => '57101',
                            'office_name' => 'Ayancık Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Durağan',
                            'office_code' => '57103',
                            'office_name' => 'Durağan Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Erfelek',
                            'office_code' => '57104',
                            'office_name' => 'Erfelek Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Gerze',
                            'office_code' => '57105',
                            'office_name' => 'Gerze Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Türkeli',
                            'office_code' => '57106',
                            'office_name' => 'Türkeli Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Dikmen',
                            'office_code' => '57107',
                            'office_name' => 'Dikmen Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 57,
                            'city_name' => 'SİNOP',
                            'town_name' => 'Saraydüzü',
                            'office_code' => '57108',
                            'office_name' => 'Saraydüzü Malmüdürlüğü',
                        ),
                ),
            58 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Merkez',
                            'office_code' => '58201',
                            'office_name' => 'Kale Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Merkez',
                            'office_code' => '58280',
                            'office_name' => 'Site Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Şarkışla',
                            'office_code' => '58260',
                            'office_name' => 'Şarkışla Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Divriği',
                            'office_code' => '58101',
                            'office_name' => 'Divriği Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Gemerek',
                            'office_code' => '58102',
                            'office_name' => 'Gemerek Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Gürün',
                            'office_code' => '58103',
                            'office_name' => 'Gürün Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Hafik',
                            'office_code' => '58104',
                            'office_name' => 'Hafik Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'İmranlı',
                            'office_code' => '58105',
                            'office_name' => 'İmranlı Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Kangal',
                            'office_code' => '58106',
                            'office_name' => 'Kangal Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Koyulhisar',
                            'office_code' => '58107',
                            'office_name' => 'Koyulhisar Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Suşehri',
                            'office_code' => '58109',
                            'office_name' => 'Suşehri Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Yıldızeli',
                            'office_code' => '58110',
                            'office_name' => 'Yıldızeli Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Zara',
                            'office_code' => '58111',
                            'office_name' => 'Zara Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Akıncılar',
                            'office_code' => '58112',
                            'office_name' => 'Akıncılar Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Altınyayla',
                            'office_code' => '58113',
                            'office_name' => 'Altınyayla Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Doğanşar',
                            'office_code' => '58114',
                            'office_name' => 'Doğanşar Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Gölova',
                            'office_code' => '58115',
                            'office_name' => 'Gölova Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 58,
                            'city_name' => 'SİVAS',
                            'town_name' => 'Ulaş',
                            'office_code' => '58116',
                            'office_name' => 'Ulaş Malmüdürlüğü',
                        ),
                ),
            59 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Merkez',
                            'office_code' => '59201',
                            'office_name' => 'Süleymanpaşa Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Merkez',
                            'office_code' => '59260',
                            'office_name' => 'Namık Kemal Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Çerkezköy',
                            'office_code' => '59261',
                            'office_name' => 'Çerkezköy Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Çorlu',
                            'office_code' => '59262',
                            'office_name' => 'Çorlu Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Hayrabolu',
                            'office_code' => '59263',
                            'office_name' => 'Hayrabolu Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Malkara',
                            'office_code' => '59264',
                            'office_name' => 'Malkara Vergi Dairesi Müdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Muratlı',
                            'office_code' => '59265',
                            'office_name' => 'Muratlı Vergi Dairesi Müdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Saray',
                            'office_code' => '59106',
                            'office_name' => 'Saray Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Şarköy',
                            'office_code' => '59107',
                            'office_name' => 'Şarköy Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 59,
                            'city_name' => 'TEKİRDAĞ',
                            'town_name' => 'Marmara',
                            'office_code' => 'Ereğlisi',
                            'office_name' => '59108 Marmara Ereğlisi Malmüdürlüğü',
                        ),
                ),
            60 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Merkez',
                            'office_code' => '60260',
                            'office_name' => 'Tokat Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Erbaa',
                            'office_code' => '60261',
                            'office_name' => 'Erbaa Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Niksar',
                            'office_code' => '60262',
                            'office_name' => 'Niksar Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Turhal',
                            'office_code' => '60263',
                            'office_name' => 'Turhal Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Zile',
                            'office_code' => '60264',
                            'office_name' => 'Zile Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Almus',
                            'office_code' => '60101',
                            'office_name' => 'Almus Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Artova',
                            'office_code' => '60102',
                            'office_name' => 'Artova Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Reşadiye',
                            'office_code' => '60105',
                            'office_name' => 'Reşadiye Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Pazar',
                            'office_code' => '60108',
                            'office_name' => 'Pazar Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Yeşilyurt',
                            'office_code' => '60109',
                            'office_name' => 'Yeşilyurt Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Başçiftlik',
                            'office_code' => '60110',
                            'office_name' => 'Başçiftlik Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 60,
                            'city_name' => 'TOKAT',
                            'town_name' => 'Sulusaray',
                            'office_code' => '60111',
                            'office_name' => 'Sulusaray Malmüdürlüğü',
                        ),
                ),
            61 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Merkez',
                            'office_code' => '61201',
                            'office_name' => 'Hızırbey Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Merkez',
                            'office_code' => '61280',
                            'office_name' => 'Karadeniz Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Akçaabat',
                            'office_code' => '61260',
                            'office_name' => 'Akçaabat Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Of',
                            'office_code' => '61261',
                            'office_name' => 'Of Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Vakfıkebir',
                            'office_code' => '61262',
                            'office_name' => 'Vakfıkebir Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Araklı',
                            'office_code' => '61102',
                            'office_name' => 'Araklı Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Arsin',
                            'office_code' => '61103',
                            'office_name' => 'Arsin Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Çaykara',
                            'office_code' => '61104',
                            'office_name' => 'Çaykara Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Maçka',
                            'office_code' => '61105',
                            'office_name' => 'Maçka Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Sürmene',
                            'office_code' => '61107',
                            'office_name' => 'Sürmene Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Tonya',
                            'office_code' => '61108',
                            'office_name' => 'Tonya Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Yomra',
                            'office_code' => '61110',
                            'office_name' => 'Yomra Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Beşikdüzü',
                            'office_code' => '61111',
                            'office_name' => 'Beşikdüzü Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Şalpazarı',
                            'office_code' => '61112',
                            'office_name' => 'Şalpazarı Malmüdürlüğü',
                        ),
                    14 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Çarşıbaşı',
                            'office_code' => '61113',
                            'office_name' => 'Çarşıbaşı Malmüdürlüğü',
                        ),
                    15 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Dernekpazarı',
                            'office_code' => '61114',
                            'office_name' => 'Dernekpazarı Malmüdürlüğü',
                        ),
                    16 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Düzköy',
                            'office_code' => '61115',
                            'office_name' => 'Düzköy Malmüdürlüğü',
                        ),
                    17 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Hayrat',
                            'office_code' => '61116',
                            'office_name' => 'Hayrat Malmüdürlüğü',
                        ),
                    18 =>
                        array(
                            'plate_no' => 61,
                            'city_name' => 'TRABZON',
                            'town_name' => 'Köprübaşı',
                            'office_code' => '61117',
                            'office_name' => 'Köprübaşı Malmüdürlüğü',
                        ),
                ),
            62 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 62,
                            'city_name' => 'TUNCELİ',
                            'town_name' => 'Merkez',
                            'office_code' => '62260',
                            'office_name' => 'Tunceli Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 62,
                            'city_name' => 'TUNCELİ',
                            'town_name' => 'Çemişgezek',
                            'office_code' => '62101',
                            'office_name' => 'Çemişgezek Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 62,
                            'city_name' => 'TUNCELİ',
                            'town_name' => 'Hozat',
                            'office_code' => '62102',
                            'office_name' => 'Hozat Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 62,
                            'city_name' => 'TUNCELİ',
                            'town_name' => 'Mazgirt',
                            'office_code' => '62103',
                            'office_name' => 'Mazgirt Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 62,
                            'city_name' => 'TUNCELİ',
                            'town_name' => 'Nazimiye',
                            'office_code' => '62104',
                            'office_name' => 'Nazimiye Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 62,
                            'city_name' => 'TUNCELİ',
                            'town_name' => 'Ovacık',
                            'office_code' => '62105',
                            'office_name' => 'Ovacık Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 62,
                            'city_name' => 'TUNCELİ',
                            'town_name' => 'Pertek',
                            'office_code' => '62106',
                            'office_name' => 'Pertek Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 62,
                            'city_name' => 'TUNCELİ',
                            'town_name' => 'Pülümür',
                            'office_code' => '62107',
                            'office_name' => 'Pülümür Malmüdürlüğü',
                        ),
                ),
            63 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Merkez',
                            'office_code' => '63201',
                            'office_name' => 'Şehitlik Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Merkez',
                            'office_code' => '63280',
                            'office_name' => 'Topçu Meydanı Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Siverek',
                            'office_code' => '63260',
                            'office_name' => 'Siverek Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Viranşehir',
                            'office_code' => '63261',
                            'office_name' => 'Viranşehir Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Birecik',
                            'office_code' => '63262',
                            'office_name' => 'Birecik Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Akçakale',
                            'office_code' => '63101',
                            'office_name' => 'Akçakale Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Bozova',
                            'office_code' => '63103',
                            'office_name' => 'Bozova Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Halfeti',
                            'office_code' => '63104',
                            'office_name' => 'Halfeti Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Hilvan',
                            'office_code' => '63105',
                            'office_name' => 'Hilvan Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Suruç',
                            'office_code' => '63107',
                            'office_name' => 'Suruç Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Ceylanpınar',
                            'office_code' => '63109',
                            'office_name' => 'Ceylanpınar Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 63,
                            'city_name' => 'ŞANLIURFA',
                            'town_name' => 'Harran',
                            'office_code' => '63110',
                            'office_name' => 'Harran Malmüdürlüğü',
                        ),
                ),
            64 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 64,
                            'city_name' => 'UŞAK',
                            'town_name' => 'Merkez',
                            'office_code' => '64260',
                            'office_name' => 'Uşak Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 64,
                            'city_name' => 'UŞAK',
                            'town_name' => 'Banaz',
                            'office_code' => '64261',
                            'office_name' => 'Banaz Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 64,
                            'city_name' => 'UŞAK',
                            'town_name' => 'Eşme',
                            'office_code' => '64262',
                            'office_name' => 'Eşme Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 64,
                            'city_name' => 'UŞAK',
                            'town_name' => 'Karahallı',
                            'office_code' => '64103',
                            'office_name' => 'Karahallı Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 64,
                            'city_name' => 'UŞAK',
                            'town_name' => 'Ulubey',
                            'office_code' => '64104',
                            'office_name' => 'Ulubey Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 64,
                            'city_name' => 'UŞAK',
                            'town_name' => 'Sivaslı',
                            'office_code' => '64105',
                            'office_name' => 'Sivaslı Malmüdürlüğü',
                        ),
                ),
            65 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Merkez',
                            'office_code' => '65260',
                            'office_name' => 'Van Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Erciş',
                            'office_code' => '65201',
                            'office_name' => 'Erciş Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Başkale',
                            'office_code' => '65101',
                            'office_name' => 'Başkale Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Çatak',
                            'office_code' => '65102',
                            'office_name' => 'Çatak Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Gevaş',
                            'office_code' => '65104',
                            'office_name' => 'Gevaş Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Gürpınar',
                            'office_code' => '65105',
                            'office_name' => 'Gürpınar Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Muradiye',
                            'office_code' => '65106',
                            'office_name' => 'Muradiye Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Özalp',
                            'office_code' => '65107',
                            'office_name' => 'Özalp Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Bahçesaray',
                            'office_code' => '65108',
                            'office_name' => 'Bahçesaray Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Çaldıran',
                            'office_code' => '65109',
                            'office_name' => 'Çaldıran Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Edremit',
                            'office_code' => '65110',
                            'office_name' => 'Edremit Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 65,
                            'city_name' => 'VAN',
                            'town_name' => 'Saray',
                            'office_code' => '65111',
                            'office_name' => 'Saray Malmüdürlüğü',
                        ),
                ),
            66 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Merkez',
                            'office_code' => '66260',
                            'office_name' => 'Yozgat Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Boğazlıyan',
                            'office_code' => '66261',
                            'office_name' => 'Boğazlıyan Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Sorgun',
                            'office_code' => '66262',
                            'office_name' => 'Sorgun Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Yerköy',
                            'office_code' => '66263',
                            'office_name' => 'Yerköy Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Akdağmadeni',
                            'office_code' => '66101',
                            'office_name' => 'Akdağmadeni Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Çayıralan',
                            'office_code' => '66103',
                            'office_name' => 'Çayıralan Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Çekerek',
                            'office_code' => '66104',
                            'office_name' => 'Çekerek Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Sarıkaya',
                            'office_code' => '66105',
                            'office_name' => 'Sarıkaya Malmüdürlüğü',
                        ),
                    8 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Şefaatli',
                            'office_code' => '66106',
                            'office_name' => 'Şefaatli Malmüdürlüğü',
                        ),
                    9 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Aydıncık',
                            'office_code' => '66109',
                            'office_name' => 'Aydıncık Malmüdürlüğü',
                        ),
                    10 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Çandır',
                            'office_code' => '66110',
                            'office_name' => 'Çandır Malmüdürlüğü',
                        ),
                    11 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Kadışehri',
                            'office_code' => '66111',
                            'office_name' => 'Kadışehri Malmüdürlüğü',
                        ),
                    12 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Saraykent',
                            'office_code' => '66112',
                            'office_name' => 'Saraykent Malmüdürlüğü',
                        ),
                    13 =>
                        array(
                            'plate_no' => 66,
                            'city_name' => 'YOZGAT',
                            'town_name' => 'Yenifakılı',
                            'office_code' => '66113',
                            'office_name' => 'Yenifakılı Malmüdürlüğü',
                        ),
                ),
            67 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 67,
                            'city_name' => 'ZONGULDAK',
                            'town_name' => 'Merkez',
                            'office_code' => '67201',
                            'office_name' => 'Uzunmehmet Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 67,
                            'city_name' => 'ZONGULDAK',
                            'town_name' => 'Merkez',
                            'office_code' => '67280',
                            'office_name' => 'Kara Elmas Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 67,
                            'city_name' => 'ZONGULDAK',
                            'town_name' => 'Ereğli',
                            'office_code' => '67261',
                            'office_name' => 'Ereğli Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 67,
                            'city_name' => 'ZONGULDAK',
                            'town_name' => 'Çaycuma',
                            'office_code' => '67263',
                            'office_name' => 'Çaycuma Vergi Dairesi Müdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 67,
                            'city_name' => 'ZONGULDAK',
                            'town_name' => 'Devrek',
                            'office_code' => '67264',
                            'office_name' => 'Devrek Vergi Dairesi Müdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 67,
                            'city_name' => 'ZONGULDAK',
                            'town_name' => 'Alaplı',
                            'office_code' => '67110',
                            'office_name' => 'Alaplı Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 67,
                            'city_name' => 'ZONGULDAK',
                            'town_name' => 'Gökçebey',
                            'office_code' => '67113',
                            'office_name' => 'Gökçebey Malmüdürlüğü',
                        ),
                ),
            68 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 68,
                            'city_name' => 'AKSARAY',
                            'town_name' => 'Merkez',
                            'office_code' => '68201',
                            'office_name' => 'Aksaray Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 68,
                            'city_name' => 'AKSARAY',
                            'town_name' => 'Ağaçören',
                            'office_code' => '68101',
                            'office_name' => 'Ağaçören Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 68,
                            'city_name' => 'AKSARAY',
                            'town_name' => 'Güzelyurt',
                            'office_code' => '68102',
                            'office_name' => 'Güzelyurt Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 68,
                            'city_name' => 'AKSARAY',
                            'town_name' => 'Ortaköy',
                            'office_code' => '68103',
                            'office_name' => 'Ortaköy Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 68,
                            'city_name' => 'AKSARAY',
                            'town_name' => 'Sarıyahşi',
                            'office_code' => '68104',
                            'office_name' => 'Sarıyahşi Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 68,
                            'city_name' => 'AKSARAY',
                            'town_name' => 'Eskil',
                            'office_code' => '68105',
                            'office_name' => 'Eskil Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 68,
                            'city_name' => 'AKSARAY',
                            'town_name' => 'Gülağaç',
                            'office_code' => '68106',
                            'office_name' => 'Gülağaç Malmüdürlüğü',
                        ),
                ),
            69 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 69,
                            'city_name' => 'BAYBURT',
                            'town_name' => 'Merkez',
                            'office_code' => '69201',
                            'office_name' => 'Bayburt Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 69,
                            'city_name' => 'BAYBURT',
                            'town_name' => 'Aydıntepe',
                            'office_code' => '69101',
                            'office_name' => 'Aydıntepe Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 69,
                            'city_name' => 'BAYBURT',
                            'town_name' => 'Demirözü',
                            'office_code' => '69102',
                            'office_name' => 'Demirözü Malmüdürlüğü',
                        ),
                ),
            70 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 70,
                            'city_name' => 'KARAMAN',
                            'town_name' => 'Merkez',
                            'office_code' => '70201',
                            'office_name' => 'Karaman Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 70,
                            'city_name' => 'KARAMAN',
                            'town_name' => 'Ayrancı',
                            'office_code' => '70101',
                            'office_name' => 'Ayrancı Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 70,
                            'city_name' => 'KARAMAN',
                            'town_name' => 'Ermenek',
                            'office_code' => '70102',
                            'office_name' => 'Ermenek Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 70,
                            'city_name' => 'KARAMAN',
                            'town_name' => 'Kazım',
                            'office_code' => 'Karabekir',
                            'office_name' => '70103 Kazım Karabekir Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 70,
                            'city_name' => 'KARAMAN',
                            'town_name' => 'Başyayla',
                            'office_code' => '70104',
                            'office_name' => 'Başyayla Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 70,
                            'city_name' => 'KARAMAN',
                            'town_name' => 'Sarıveliler',
                            'office_code' => '70105',
                            'office_name' => 'Sarıveliler Malmüdürlüğü',
                        ),
                ),
            71 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 71,
                            'city_name' => 'KIRIKKALE',
                            'town_name' => 'Merkez',
                            'office_code' => '71201',
                            'office_name' => 'Irmak Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 71,
                            'city_name' => 'KIRIKKALE',
                            'town_name' => 'Merkez',
                            'office_code' => '71202',
                            'office_name' => 'Kaletepe Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 71,
                            'city_name' => 'KIRIKKALE',
                            'town_name' => 'Delice',
                            'office_code' => '71101',
                            'office_name' => 'Delice Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 71,
                            'city_name' => 'KIRIKKALE',
                            'town_name' => 'Keskin',
                            'office_code' => '71102',
                            'office_name' => 'Keskin Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 71,
                            'city_name' => 'KIRIKKALE',
                            'town_name' => 'Sulakyurt',
                            'office_code' => '71103',
                            'office_name' => 'Sulakyurt Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 71,
                            'city_name' => 'KIRIKKALE',
                            'town_name' => 'Balışeyh',
                            'office_code' => '71105',
                            'office_name' => 'Balışeyh Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 71,
                            'city_name' => 'KIRIKKALE',
                            'town_name' => 'Çelebi',
                            'office_code' => '71106',
                            'office_name' => 'Çelebi Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 71,
                            'city_name' => 'KIRIKKALE',
                            'town_name' => 'Karakeçili',
                            'office_code' => '71107',
                            'office_name' => 'Karakeçili Malmüdürlüğü',
                        ),
                ),
            72 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 72,
                            'city_name' => 'BATMAN',
                            'town_name' => 'Merkez',
                            'office_code' => '72260',
                            'office_name' => 'Batman Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 72,
                            'city_name' => 'BATMAN',
                            'town_name' => 'Beşiri',
                            'office_code' => '72101',
                            'office_name' => 'Beşiri Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 72,
                            'city_name' => 'BATMAN',
                            'town_name' => 'Gercüş',
                            'office_code' => '72102',
                            'office_name' => 'Gercüş Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 72,
                            'city_name' => 'BATMAN',
                            'town_name' => 'Hasankeyf',
                            'office_code' => '72103',
                            'office_name' => 'Hasankeyf Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 72,
                            'city_name' => 'BATMAN',
                            'town_name' => 'Kozluk',
                            'office_code' => '72104',
                            'office_name' => 'Kozluk Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 72,
                            'city_name' => 'BATMAN',
                            'town_name' => 'Sason',
                            'office_code' => '72105',
                            'office_name' => 'Sason Malmüdürlüğü',
                        ),
                ),
            73 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 73,
                            'city_name' => 'ŞIRNAK',
                            'town_name' => 'Merkez',
                            'office_code' => '73260',
                            'office_name' => 'Şırnak Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 73,
                            'city_name' => 'ŞIRNAK',
                            'town_name' => 'Cizre',
                            'office_code' => '73261',
                            'office_name' => 'Cizre Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 73,
                            'city_name' => 'ŞIRNAK',
                            'town_name' => 'Silopi',
                            'office_code' => '73262',
                            'office_name' => 'Silopi Vergi Dairesi Müdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 73,
                            'city_name' => 'ŞIRNAK',
                            'town_name' => 'Beytüşşebap',
                            'office_code' => '73101',
                            'office_name' => 'Beytüşşebap Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 73,
                            'city_name' => 'ŞIRNAK',
                            'town_name' => 'Güçlükonak',
                            'office_code' => '73103',
                            'office_name' => 'Güçlükonak Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 73,
                            'city_name' => 'ŞIRNAK',
                            'town_name' => 'İdil',
                            'office_code' => '73104',
                            'office_name' => 'İdil Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 73,
                            'city_name' => 'ŞIRNAK',
                            'town_name' => 'Uludere',
                            'office_code' => '73106',
                            'office_name' => 'Uludere Malmüdürlüğü',
                        ),
                ),
            74 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 74,
                            'city_name' => 'BARTIN',
                            'town_name' => 'Merkez',
                            'office_code' => '74260',
                            'office_name' => 'Bartın Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 74,
                            'city_name' => 'BARTIN',
                            'town_name' => 'Amasra',
                            'office_code' => '74101',
                            'office_name' => 'Amasra Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 74,
                            'city_name' => 'BARTIN',
                            'town_name' => 'Kurucaşile',
                            'office_code' => '74102',
                            'office_name' => 'Kurucaşile Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 74,
                            'city_name' => 'BARTIN',
                            'town_name' => 'Ulus',
                            'office_code' => '74103',
                            'office_name' => 'Ulus Malmüdürlüğü',
                        ),
                ),
            75 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 75,
                            'city_name' => 'ARDAHAN',
                            'town_name' => 'Merkez',
                            'office_code' => '75201',
                            'office_name' => 'Ardahan Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 75,
                            'city_name' => 'ARDAHAN',
                            'town_name' => 'Çıldır',
                            'office_code' => '75101',
                            'office_name' => 'Çıldır Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 75,
                            'city_name' => 'ARDAHAN',
                            'town_name' => 'Damal',
                            'office_code' => '75102',
                            'office_name' => 'Damal Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 75,
                            'city_name' => 'ARDAHAN',
                            'town_name' => 'Göle',
                            'office_code' => '75103',
                            'office_name' => 'Göle Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 75,
                            'city_name' => 'ARDAHAN',
                            'town_name' => 'Hanak',
                            'office_code' => '75104',
                            'office_name' => 'Hanak Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 75,
                            'city_name' => 'ARDAHAN',
                            'town_name' => 'Posof',
                            'office_code' => '75105',
                            'office_name' => 'Posof Malmüdürlüğü',
                        ),
                ),
            76 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 76,
                            'city_name' => 'IĞDIR',
                            'town_name' => 'Merkez',
                            'office_code' => '76201',
                            'office_name' => 'Iğdır Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 76,
                            'city_name' => 'IĞDIR',
                            'town_name' => 'Aralık',
                            'office_code' => '76101',
                            'office_name' => 'Aralık Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 76,
                            'city_name' => 'IĞDIR',
                            'town_name' => 'Karakoyunlu',
                            'office_code' => '76102',
                            'office_name' => 'Karakoyunlu Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 76,
                            'city_name' => 'IĞDIR',
                            'town_name' => 'Tuzluca',
                            'office_code' => '76103',
                            'office_name' => 'Tuzluca Malmüdürlüğü',
                        ),
                ),
            77 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 77,
                            'city_name' => 'YALOVA',
                            'town_name' => 'Merkez',
                            'office_code' => '77201',
                            'office_name' => 'Yalova Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 77,
                            'city_name' => 'YALOVA',
                            'town_name' => 'Altınova',
                            'office_code' => '77101',
                            'office_name' => 'Altınova Malmüdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 77,
                            'city_name' => 'YALOVA',
                            'town_name' => 'Armutlu',
                            'office_code' => '77102',
                            'office_name' => 'Armutlu Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 77,
                            'city_name' => 'YALOVA',
                            'town_name' => 'Çınarcık',
                            'office_code' => '77103',
                            'office_name' => 'Çınarcık Malmüdürlüğü',
                        ),
                ),
            78 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 78,
                            'city_name' => 'KARABÜK',
                            'town_name' => 'Merkez',
                            'office_code' => '78201',
                            'office_name' => 'Karabük Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 78,
                            'city_name' => 'KARABÜK',
                            'town_name' => 'Safranbolu',
                            'office_code' => '78260',
                            'office_name' => 'Safranbolu Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 78,
                            'city_name' => 'KARABÜK',
                            'town_name' => 'Eflani',
                            'office_code' => '78101',
                            'office_name' => 'Eflani Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 78,
                            'city_name' => 'KARABÜK',
                            'town_name' => 'Eskipazar',
                            'office_code' => '78102',
                            'office_name' => 'Eskipazar Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 78,
                            'city_name' => 'KARABÜK',
                            'town_name' => 'Ovacık',
                            'office_code' => '78103',
                            'office_name' => 'Ovacık Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 78,
                            'city_name' => 'KARABÜK',
                            'town_name' => 'Yenice',
                            'office_code' => '78105',
                            'office_name' => 'Yenice Malmüdürlüğü',
                        ),
                ),
            79 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 79,
                            'city_name' => 'KİLİS',
                            'town_name' => 'Merkez',
                            'office_code' => '79201',
                            'office_name' => 'Kilis Vergi Dairesi Müdürlüğü',
                        ),
                ),
            80 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 80,
                            'city_name' => 'OSMANİYE',
                            'town_name' => 'Merkez',
                            'office_code' => '80201',
                            'office_name' => 'Osmaniye Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 80,
                            'city_name' => 'OSMANİYE',
                            'town_name' => 'Kadirli',
                            'office_code' => '80260',
                            'office_name' => 'Kadirli Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 80,
                            'city_name' => 'OSMANİYE',
                            'town_name' => 'Bahçe',
                            'office_code' => '80101',
                            'office_name' => 'Bahçe Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 80,
                            'city_name' => 'OSMANİYE',
                            'town_name' => 'Düziçi',
                            'office_code' => '80102',
                            'office_name' => 'Düziçi Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 80,
                            'city_name' => 'OSMANİYE',
                            'town_name' => 'Hasanbeyli',
                            'office_code' => '80104',
                            'office_name' => 'Hasanbeyli Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 80,
                            'city_name' => 'OSMANİYE',
                            'town_name' => 'Sumbas',
                            'office_code' => '80105',
                            'office_name' => 'Sumbas Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 80,
                            'city_name' => 'OSMANİYE',
                            'town_name' => 'Toprakkale',
                            'office_code' => '80106',
                            'office_name' => 'Toprakkale Malmüdürlüğü',
                        ),
                ),
            81 =>
                array(
                    0 =>
                        array(
                            'plate_no' => 81,
                            'city_name' => 'DÜZCE',
                            'town_name' => 'Merkez',
                            'office_code' => '81260',
                            'office_name' => 'Düzce Vergi Dairesi Müdürlüğü',
                        ),
                    1 =>
                        array(
                            'plate_no' => 81,
                            'city_name' => 'DÜZCE',
                            'town_name' => 'Akçakoca',
                            'office_code' => '81261',
                            'office_name' => 'Akçakoca Vergi Dairesi Müdürlüğü',
                        ),
                    2 =>
                        array(
                            'plate_no' => 81,
                            'city_name' => 'DÜZCE',
                            'town_name' => 'Yığılca',
                            'office_code' => '81107',
                            'office_name' => 'Yığılca Malmüdürlüğü',
                        ),
                    3 =>
                        array(
                            'plate_no' => 81,
                            'city_name' => 'DÜZCE',
                            'town_name' => 'Cumayeri',
                            'office_code' => '81102',
                            'office_name' => 'Cumayeri Malmüdürlüğü',
                        ),
                    4 =>
                        array(
                            'plate_no' => 81,
                            'city_name' => 'DÜZCE',
                            'town_name' => 'Gölyaka',
                            'office_code' => '81104',
                            'office_name' => 'Gölyaka Malmüdürlüğü',
                        ),
                    5 =>
                        array(
                            'plate_no' => 81,
                            'city_name' => 'DÜZCE',
                            'town_name' => 'Çilimli',
                            'office_code' => '81103',
                            'office_name' => 'Çilimli Malmüdürlüğü',
                        ),
                    6 =>
                        array(
                            'plate_no' => 81,
                            'city_name' => 'DÜZCE',
                            'town_name' => 'Gümüşova',
                            'office_code' => '81105',
                            'office_name' => 'Gümüşova Malmüdürlüğü',
                        ),
                    7 =>
                        array(
                            'plate_no' => 81,
                            'city_name' => 'DÜZCE',
                            'town_name' => 'Kaynaşlı',
                            'office_code' => '81106',
                            'office_name' => 'Kaynaşlı Malmüdürlüğü',
                        ),
                ),
        );

    }

    public function GetCompanyName()
    {
        return $this->CompanyNames[mt_rand(0,sizeof($this->CompanyNames)-1)];
    }

    public function GetTaxOffice($plateNo)
    {
        $city = $this->TaxOffices[$plateNo];
        return $city[mt_rand(0,sizeof($city)-1)];
    }

    public function GetVehicle()
    {
        /*"Ford:Transit:1993:2017:15:4:1"*/
        $_v = $this->VehicleModels[mt_rand(0,sizeof($this->VehicleModels)-1)];
        $vData = explode(":",$_v);
        /*
        $v = new \Ay\Core\Entity\Seed\Vehicle();
        $v->Mark = $vData[0];
        $v->Model = $vData[1];
        $v->Year = mt_rand($vData[2],$vData[3]);
        $v->FuelConsumption = $vData[4];
        $v->TypeId = $vData[5];
        $v->FuelTypeId = $vData[6];
        */
        return $vData;
    }

    public function PreparePlate($ciytPlate)
    {
        if($ciytPlate < 10) {
            $ciytPlate = "0".$ciytPlate;
        }

        $lSize = mt_rand(1,3);
        $maxNum = 9999;
        if($lSize == 2) { $maxNum = 999; }
        if($lSize == 3) { $maxNum = 99; }
        $letters = self::randomChars($lSize,false,true,true);
        $nums = mt_rand(1,$maxNum);

        return $ciytPlate." ".$letters." ".$nums;
    }

    public function GetEmail($name,$len = 1,$domain=false)
    {
        $clean = str_replace(" ",".",mb_strtolower($name));
        $arrName = explode(".",$clean);
        $nam = [];
        for($i = 0;$i<$len;$i++) {
            $nam[] = $arrName[$i];
        }
        $enam = implode(".",$nam);
        if(!$domain) {
            $email = $enam.'@'.$this->EmailProviders[mt_rand(0,sizeof($this->EmailProviders)-1)];
        } else {
            $email = $enam.'@'.$domain;
        }

        if(isset($this->_email[$email])) {
            $email = $this->GetEmail($name,$len+1);
        }
        $this->_email[$email] = 1;
        return $email;
    }

    public function GetCompanyDomain($name,$tld='int',$len=1)
    {
        $clean = str_replace(" ","-",mb_strtolower($name));
        $arrName = explode("-",$clean);
        $nam = [];

        if(sizeof($arrName) >= $len) {
            for($i = 0;$i<$len;$i++) {
                $nam[] = $arrName[$i];
            }
            $host = implode("-",$nam).'.'.$tld;
        } else {
            $host = $name.'.'.strtolower(self::randomChars(4,false,true)).'.'.$tld;
        }

        if(isset($this->_doms[$host])) {
            $host = $this->GetCompanyDomain($name,$tld,$len+1);
        }
        $this->_doms[$host] = 1;
        return $host;
    }

    public function GenPhone($baseCode)
    {
        return $baseCode.mt_rand(210,789).mt_rand(10,99).mt_rand(10,99);
    }

    public function GetName($gender=false)
    {
        if(!$gender) {
            $gender = (mt_rand(1,2) ==2) ? 'w' : 'm';
        }

        $r = [];
        $names = $this->HumanNames[$gender];
        $myName = mt_rand(0,sizeof($this->HumanNames[$gender])-1);
        $i = 0;
        foreach($names as $name) {
            if($i == $myName) {
                break;
            }
            $r['name'] = $name;
            $i++;
        }
        $r['gender'] = ($gender == 'w') ? 2 : 1;
        return $r;
    }

    public function GetSurname()
    {
        return $this->Surnames[mt_rand(0,sizeof($this->Surnames)-1)];
    }

    public function GetNationalId()
    {
        return mt_rand(10000000000,99999999999);
    }

    public function GetTaxId()
    {
        return mt_rand(2000000000,9999999999);
    }

    public function GetCity($fix='40')
    {
        //return $this->ListCity[rand(0,sizeof($this->ListCity)-1)];
        if($fix) {
            $fix = (string) $fix;
            return $this->ListCity[$fix];
        }
        return $this->ListCity[rand(0,sizeof($this->ListCity)-1)];
    }

    public function GetTown($cityId)
    {
        return $this->ListCounty[$cityId][mt_rand(0,sizeof($this->ListCounty[$cityId])-1)];
    }

    public function GetArea($townId)
    {
        return $this->ListArea[$townId][mt_rand(0,sizeof($this->ListArea[$townId])-1)];
    }

    public function GetNeigh($areaId)
    {
        return $this->ListNeigh[$areaId][mt_rand(0,sizeof($this->ListNeigh[$areaId])-1)];
    }

    public function ParseAreaName($area)
    {
        return mb_convert_case($area['area_name'],MB_CASE_TITLE,"UTF-8");
    }

    public function ParseNeighName($neigh)
    {
        return mb_convert_case($neigh['neighborhood_name'],MB_CASE_TITLE,"UTF-8");
    }

    public function GetAddress($areaName,$neighName)
    {
        return str_replace(["\n","\r"],"",$neighName." ".$this->GetHomeStreet()." No:".mt_rand(15,567)." - ".$areaName);
    }

    public function GetHomeStreet()
    {
        return mb_convert_case($this->StreetNames[mt_rand(0,sizeof($this->StreetNames)-1)],MB_CASE_TITLE,"UTF-8");
    }

    public static function validateIp($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP,
                FILTER_FLAG_IPV4 |
                FILTER_FLAG_IPV6 |
                FILTER_FLAG_NO_PRIV_RANGE |
                FILTER_FLAG_NO_RES_RANGE) === false)
            return false;
        return true;
    }

    /**
     * randomChars#
     * generates random string
     */
    public static function randomChars ($pw_length = 8, $numOnly = false,$noNum=false,$isPlate=false) {
        $i = 0;
        $password = '';
        if($numOnly == false) {
            // Exclude special characters and some confusing alphanumerics
            // o,O,0,I,1,l etc
            $notuse = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
            if($isPlate) {
                $notuse = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111,81,87,88);
            }
            if(!$noNum) {
                // set ASCII range for random character generation
                $lower_ascii_bound = 50;  // "2"
                $upper_ascii_bound = 122; // "z"
            } else {
                $lower_ascii_bound = 65;  // "A"
                $upper_ascii_bound = 122; // "z"
                if($isPlate) {
                    $upper_ascii_bound = 90; // "Z"
                }
            }
            while ($i < $pw_length) {
                mt_srand ((int)microtime() * 1000000);
                // random limits within ASCII table
                $randnum = mt_rand ($lower_ascii_bound, $upper_ascii_bound);
                if (!in_array ($randnum, $notuse)) {
                    $password = $password . chr($randnum);
                    $i++;
                }
            }
        } else {
            $n = [];
            while ($i < $pw_length) {
                $n[] = rand(0,9);
                $i++;
            }
            $password = implode('',$n);
        }
        if(!$isPlate) {
            return $password;
        }
        return strtoupper($password);
    }

    public static function ActivitionCode()
    {
        return self::randomChars(3,true).self::randomChars(3,true).self::randomChars(2,true).self::randomChars(2,true);
    }

    public static function crcObj($obj)
    {
        return crc32(serialize($obj));
    }

}
