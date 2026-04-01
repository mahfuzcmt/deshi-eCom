<?php defined('ABSPATH') || exit;

/**
 * Returns all 64 districts of Bangladesh with their major thanas/upazilas.
 *
 * @return array Associative array keyed by district slug.
 */
function tot_get_bangladesh_data() {
    return array(

        // =====================================================================
        // Barisal Division
        // =====================================================================

        'barguna' => array(
            'label'  => 'Barguna',
            'thanas' => array(
                'amtali'        => 'Amtali',
                'bamna'         => 'Bamna',
                'barguna_sadar' => 'Barguna Sadar',
                'betagi'        => 'Betagi',
                'patharghata'   => 'Patharghata',
                'taltali'       => 'Taltali',
            ),
        ),

        'barisal' => array(
            'label'  => 'Barisal',
            'thanas' => array(
                'agailjhara'    => 'Agailjhara',
                'babuganj'      => 'Babuganj',
                'bakerganj'     => 'Bakerganj',
                'banaripara'    => 'Banaripara',
                'barisal_sadar' => 'Barisal Sadar',
                'gournadi'      => 'Gournadi',
                'hizla'         => 'Hizla',
                'mehendiganj'   => 'Mehendiganj',
                'muladi'        => 'Muladi',
                'wazirpur'      => 'Wazirpur',
            ),
        ),

        'bhola' => array(
            'label'  => 'Bhola',
            'thanas' => array(
                'bhola_sadar'  => 'Bhola Sadar',
                'borhanuddin'  => 'Borhanuddin',
                'char_fasson'  => 'Char Fasson',
                'daulatkhan'   => 'Daulatkhan',
                'lalmohan'     => 'Lalmohan',
                'manpura'      => 'Manpura',
                'tazumuddin'   => 'Tazumuddin',
            ),
        ),

        'jhalokati' => array(
            'label'  => 'Jhalokati',
            'thanas' => array(
                'jhalokati_sadar' => 'Jhalokati Sadar',
                'kathalia'        => 'Kathalia',
                'nalchity'        => 'Nalchity',
                'rajapur'         => 'Rajapur',
            ),
        ),

        'patuakhali' => array(
            'label'  => 'Patuakhali',
            'thanas' => array(
                'bauphal'           => 'Bauphal',
                'dashmina'          => 'Dashmina',
                'dumki'             => 'Dumki',
                'galachipa'         => 'Galachipa',
                'kalapara'          => 'Kalapara',
                'mirzaganj'         => 'Mirzaganj',
                'patuakhali_sadar'  => 'Patuakhali Sadar',
                'rangabali'         => 'Rangabali',
            ),
        ),

        'pirojpur' => array(
            'label'  => 'Pirojpur',
            'thanas' => array(
                'bhandaria'      => 'Bhandaria',
                'kawkhali'       => 'Kawkhali',
                'mathbaria'      => 'Mathbaria',
                'nazirpur'       => 'Nazirpur',
                'nesarabad'      => 'Nesarabad (Swarupkathi)',
                'pirojpur_sadar' => 'Pirojpur Sadar',
                'zianagar'       => 'Zianagar',
            ),
        ),

        // =====================================================================
        // Chittagong Division
        // =====================================================================

        'bandarban' => array(
            'label'  => 'Bandarban',
            'thanas' => array(
                'ali_kadam'       => 'Ali Kadam',
                'bandarban_sadar' => 'Bandarban Sadar',
                'lama'            => 'Lama',
                'naikhongchhari'  => 'Naikhongchhari',
                'rowangchhari'    => 'Rowangchhari',
                'ruma'            => 'Ruma',
                'thanchi'         => 'Thanchi',
            ),
        ),

        'brahmanbaria' => array(
            'label'  => 'Brahmanbaria',
            'thanas' => array(
                'akhaura'             => 'Akhaura',
                'ashuganj'            => 'Ashuganj',
                'bancharampur'        => 'Bancharampur',
                'brahmanbaria_sadar'  => 'Brahmanbaria Sadar',
                'kasba'               => 'Kasba',
                'nabinagar'           => 'Nabinagar',
                'nasirnagar'          => 'Nasirnagar',
                'sarail'              => 'Sarail',
                'bijoynagar'          => 'Bijoynagar',
            ),
        ),

        'chandpur' => array(
            'label'  => 'Chandpur',
            'thanas' => array(
                'chandpur_sadar' => 'Chandpur Sadar',
                'faridganj'      => 'Faridganj',
                'haimchar'       => 'Haimchar',
                'hajiganj'       => 'Hajiganj',
                'kachua'         => 'Kachua',
                'matlab_dakshin' => 'Matlab Dakshin',
                'matlab_uttar'   => 'Matlab Uttar',
                'shahrasti'      => 'Shahrasti',
            ),
        ),

        'chittagong' => array(
            'label'  => 'Chittagong',
            'thanas' => array(
                'anwara'           => 'Anwara',
                'banshkhali'       => 'Banshkhali',
                'boalkhali'        => 'Boalkhali',
                'chandanaish'      => 'Chandanaish',
                'fatikchhari'      => 'Fatikchhari',
                'hathazari'        => 'Hathazari',
                'lohagara'         => 'Lohagara',
                'mirsharai'        => 'Mirsharai',
                'patiya'           => 'Patiya',
                'rangunia'         => 'Rangunia',
                'raozan'           => 'Raozan',
                'sandwip'          => 'Sandwip',
                'satkania'         => 'Satkania',
                'sitakunda'        => 'Sitakunda',
                'kotwali'          => 'Kotwali',
                'panchlaish'       => 'Panchlaish',
                'pahartali'        => 'Pahartali',
                'bakalia'          => 'Bakalia',
                'bayezid'          => 'Bayezid',
                'chandgaon'        => 'Chandgaon',
                'double_mooring'   => 'Double Mooring',
                'halishahar'       => 'Halishahar',
                'khulshi'          => 'Khulshi',
                'patenga'          => 'Patenga',
                'bandar'           => 'Bandar',
                'akbar_shah'       => 'Akbar Shah',
                'eidgaon'          => 'Eidgaon (Karnaphuli)',
            ),
        ),

        'comilla' => array(
            'label'  => 'Comilla',
            'thanas' => array(
                'barura'             => 'Barura',
                'brahmanpara'        => 'Brahmanpara',
                'burichang'          => 'Burichang',
                'chandina'           => 'Chandina',
                'chauddagram'        => 'Chauddagram',
                'comilla_adarsha_sadar' => 'Comilla Adarsha Sadar',
                'comilla_sadar_dakshin' => 'Comilla Sadar Dakshin',
                'daudkandi'          => 'Daudkandi',
                'debidwar'           => 'Debidwar',
                'homna'              => 'Homna',
                'laksam'             => 'Laksam',
                'lalmai'             => 'Lalmai',
                'meghna'             => 'Meghna',
                'monohorgonj'        => 'Monohorgonj',
                'muradnagar'         => 'Muradnagar',
                'nangalkot'          => 'Nangalkot',
                'titas'              => 'Titas',
            ),
        ),

        'coxs_bazar' => array(
            'label'  => 'Cox\'s Bazar',
            'thanas' => array(
                'chakaria'          => 'Chakaria',
                'coxs_bazar_sadar'  => 'Cox\'s Bazar Sadar',
                'kutubdia'          => 'Kutubdia',
                'maheshkhali'       => 'Maheshkhali',
                'pekua'             => 'Pekua',
                'ramu'              => 'Ramu',
                'teknaf'            => 'Teknaf',
                'ukhia'             => 'Ukhia',
            ),
        ),

        'feni' => array(
            'label'  => 'Feni',
            'thanas' => array(
                'chhagalnaiya' => 'Chhagalnaiya',
                'daganbhuiyan' => 'Daganbhuiyan',
                'feni_sadar'   => 'Feni Sadar',
                'fulgazi'      => 'Fulgazi',
                'parshuram'    => 'Parshuram',
                'sonagazi'     => 'Sonagazi',
            ),
        ),

        'khagrachhari' => array(
            'label'  => 'Khagrachhari',
            'thanas' => array(
                'dighinala'          => 'Dighinala',
                'guimara'            => 'Guimara',
                'khagrachhari_sadar' => 'Khagrachhari Sadar',
                'lakshmichhari'      => 'Lakshmichhari',
                'mahalchhari'        => 'Mahalchhari',
                'manikchhari'        => 'Manikchhari',
                'matiranga'          => 'Matiranga',
                'panchhari'          => 'Panchhari',
                'ramgarh'            => 'Ramgarh',
            ),
        ),

        'lakshmipur' => array(
            'label'  => 'Lakshmipur',
            'thanas' => array(
                'kamalnagar'       => 'Kamalnagar',
                'lakshmipur_sadar' => 'Lakshmipur Sadar',
                'raipur'           => 'Raipur',
                'ramganj'          => 'Ramganj',
                'ramgati'          => 'Ramgati',
            ),
        ),

        'noakhali' => array(
            'label'  => 'Noakhali',
            'thanas' => array(
                'begumganj'      => 'Begumganj',
                'chatkhil'       => 'Chatkhil',
                'companiganj'    => 'Companiganj',
                'hatiya'         => 'Hatiya',
                'kabirhat'       => 'Kabirhat',
                'noakhali_sadar' => 'Noakhali Sadar',
                'senbagh'        => 'Senbagh',
                'sonaimuri'      => 'Sonaimuri',
                'subarnachar'    => 'Subarnachar',
            ),
        ),

        'rangamati' => array(
            'label'  => 'Rangamati',
            'thanas' => array(
                'baghaichhari'     => 'Baghaichhari',
                'barkal'           => 'Barkal',
                'belaichhari'      => 'Belaichhari',
                'juraichhari'      => 'Juraichhari',
                'kaptai'           => 'Kaptai',
                'kawkhali_rm'      => 'Kawkhali',
                'langadu'          => 'Langadu',
                'naniyarchar'      => 'Naniyarchar',
                'rajasthali'       => 'Rajasthali',
                'rangamati_sadar'  => 'Rangamati Sadar',
            ),
        ),

        // =====================================================================
        // Dhaka Division
        // =====================================================================

        'dhaka' => array(
            'label'  => 'Dhaka',
            'thanas' => array(
                'dhanmondi'       => 'Dhanmondi',
                'gulshan'         => 'Gulshan',
                'mirpur'          => 'Mirpur',
                'mohammadpur'     => 'Mohammadpur',
                'uttara'          => 'Uttara',
                'tejgaon'         => 'Tejgaon',
                'motijheel'       => 'Motijheel',
                'ramna'           => 'Ramna',
                'lalbagh'         => 'Lalbagh',
                'savar'           => 'Savar',
                'keraniganj'      => 'Keraniganj',
                'dohar'           => 'Dohar',
                'nawabganj_dhk'   => 'Nawabganj',
                'demra'           => 'Demra',
                'kadamtali'       => 'Kadamtali',
                'wari'            => 'Wari',
                'sutrapur'        => 'Sutrapur',
                'kotwali_dhk'     => 'Kotwali',
                'bangshal'        => 'Bangshal',
                'hazaribagh'      => 'Hazaribagh',
                'kamrangirchar'   => 'Kamrangirchar',
                'khilgaon'        => 'Khilgaon',
                'sabujbagh'       => 'Sabujbagh',
                'kafrul'          => 'Kafrul',
                'pallabi'         => 'Pallabi',
                'shah_ali'        => 'Shah Ali',
                'turag'           => 'Turag',
                'badda'           => 'Badda',
                'vatara'          => 'Vatara',
                'uttarkhan'       => 'Uttarkhan',
                'dakshinkhan'     => 'Dakshinkhan',
                'tejgaon_industrial' => 'Tejgaon Industrial',
                'adabor'          => 'Adabor',
                'shyampur'        => 'Shyampur',
                'jatrabari'       => 'Jatrabari',
                'dhamrai'         => 'Dhamrai',
                'shahbagh'        => 'Shahbagh',
                'newmarket'       => 'New Market',
                'paltan'          => 'Paltan',
                'cantonment'      => 'Cantonment',
                'bimanbandar'     => 'Bimanbandar',
                'chackbazar'      => 'Chackbazar',
                'hajaribag'       => 'Hajaribag',
                'gendaria'        => 'Gendaria',
                'rampura'         => 'Rampura',
            ),
        ),

        'faridpur' => array(
            'label'  => 'Faridpur',
            'thanas' => array(
                'alfadanga'      => 'Alfadanga',
                'bhanga'         => 'Bhanga',
                'boalmari'       => 'Boalmari',
                'charbhadrasan'  => 'Charbhadrasan',
                'faridpur_sadar' => 'Faridpur Sadar',
                'madhukhali'     => 'Madhukhali',
                'nagarkanda'     => 'Nagarkanda',
                'sadarpur'       => 'Sadarpur',
                'saltha'         => 'Saltha',
            ),
        ),

        'gazipur' => array(
            'label'  => 'Gazipur',
            'thanas' => array(
                'gazipur_sadar' => 'Gazipur Sadar',
                'kaliakair'     => 'Kaliakair',
                'kaliganj'      => 'Kaliganj',
                'kapasia'       => 'Kapasia',
                'sreepur'       => 'Sreepur',
                'tongi'         => 'Tongi',
            ),
        ),

        'gopalganj' => array(
            'label'  => 'Gopalganj',
            'thanas' => array(
                'gopalganj_sadar' => 'Gopalganj Sadar',
                'kashiani'        => 'Kashiani',
                'kotalipara'      => 'Kotalipara',
                'muksudpur'       => 'Muksudpur',
                'tungipara'       => 'Tungipara',
            ),
        ),

        'kishoreganj' => array(
            'label'  => 'Kishoreganj',
            'thanas' => array(
                'austagram'          => 'Austagram',
                'bajitpur'           => 'Bajitpur',
                'bhairab'            => 'Bhairab',
                'hossainpur'         => 'Hossainpur',
                'itna'               => 'Itna',
                'karimganj'          => 'Karimganj',
                'katiadi'            => 'Katiadi',
                'kishoreganj_sadar'  => 'Kishoreganj Sadar',
                'kuliarchar'         => 'Kuliarchar',
                'mithamain'          => 'Mithamain',
                'nikli'              => 'Nikli',
                'pakundia'           => 'Pakundia',
                'tarail'             => 'Tarail',
            ),
        ),

        'madaripur' => array(
            'label'  => 'Madaripur',
            'thanas' => array(
                'kalkini'          => 'Kalkini',
                'madaripur_sadar'  => 'Madaripur Sadar',
                'rajoir'           => 'Rajoir',
                'shibchar'         => 'Shibchar',
                'dasar'            => 'Dasar',
            ),
        ),

        'manikganj' => array(
            'label'  => 'Manikganj',
            'thanas' => array(
                'daulatpur'        => 'Daulatpur',
                'ghior'            => 'Ghior',
                'harirampur'       => 'Harirampur',
                'manikganj_sadar'  => 'Manikganj Sadar',
                'saturia'          => 'Saturia',
                'shivalaya'        => 'Shivalaya',
                'singair'          => 'Singair',
            ),
        ),

        'munshiganj' => array(
            'label'  => 'Munshiganj',
            'thanas' => array(
                'gazaria'          => 'Gazaria',
                'lohajang'         => 'Lohajang',
                'munshiganj_sadar' => 'Munshiganj Sadar',
                'sirajdikhan'      => 'Sirajdikhan',
                'sreenagar'        => 'Sreenagar',
                'tongibari'        => 'Tongibari',
            ),
        ),

        'narayanganj' => array(
            'label'  => 'Narayanganj',
            'thanas' => array(
                'araihazar'           => 'Araihazar',
                'bandar_nrj'          => 'Bandar',
                'narayanganj_sadar'   => 'Narayanganj Sadar',
                'rupganj'             => 'Rupganj',
                'sonargaon'           => 'Sonargaon',
                'siddhirganj'         => 'Siddhirganj',
                'fatullah'            => 'Fatullah',
            ),
        ),

        'narsingdi' => array(
            'label'  => 'Narsingdi',
            'thanas' => array(
                'belabo'           => 'Belabo',
                'monohardi'        => 'Monohardi',
                'narsingdi_sadar'  => 'Narsingdi Sadar',
                'palash'           => 'Palash',
                'raipura'          => 'Raipura',
                'shibpur'          => 'Shibpur',
            ),
        ),

        'rajbari' => array(
            'label'  => 'Rajbari',
            'thanas' => array(
                'baliakandi'    => 'Baliakandi',
                'goalandaghat'  => 'Goalandaghat',
                'kalukhali'     => 'Kalukhali',
                'pangsha'       => 'Pangsha',
                'rajbari_sadar' => 'Rajbari Sadar',
            ),
        ),

        'shariatpur' => array(
            'label'  => 'Shariatpur',
            'thanas' => array(
                'bhedarganj'       => 'Bhedarganj',
                'damudya'          => 'Damudya',
                'gosairhat'        => 'Gosairhat',
                'naria'            => 'Naria',
                'shariatpur_sadar' => 'Shariatpur Sadar',
                'zanjira'          => 'Zanjira',
            ),
        ),

        'tangail' => array(
            'label'  => 'Tangail',
            'thanas' => array(
                'basail'         => 'Basail',
                'bhuapur'        => 'Bhuapur',
                'delduar'        => 'Delduar',
                'dhanbari'       => 'Dhanbari',
                'ghatail'        => 'Ghatail',
                'gopalpur'       => 'Gopalpur',
                'kalihati'       => 'Kalihati',
                'madhupur'       => 'Madhupur',
                'mirzapur'       => 'Mirzapur',
                'nagarpur'       => 'Nagarpur',
                'sakhipur'       => 'Sakhipur',
                'tangail_sadar'  => 'Tangail Sadar',
            ),
        ),

        // =====================================================================
        // Khulna Division
        // =====================================================================

        'bagerhat' => array(
            'label'  => 'Bagerhat',
            'thanas' => array(
                'bagerhat_sadar' => 'Bagerhat Sadar',
                'chitalmari'     => 'Chitalmari',
                'fakirhat'       => 'Fakirhat',
                'kachua_bg'      => 'Kachua',
                'mollahat'       => 'Mollahat',
                'mongla'         => 'Mongla',
                'morrelganj'     => 'Morrelganj',
                'rampal'         => 'Rampal',
                'sarankhola'     => 'Sarankhola',
            ),
        ),

        'chuadanga' => array(
            'label'  => 'Chuadanga',
            'thanas' => array(
                'alamdanga'        => 'Alamdanga',
                'chuadanga_sadar'  => 'Chuadanga Sadar',
                'damurhuda'        => 'Damurhuda',
                'jibannagar'       => 'Jibannagar',
            ),
        ),

        'jessore' => array(
            'label'  => 'Jessore',
            'thanas' => array(
                'abhaynagar'    => 'Abhaynagar',
                'bagherpara'    => 'Bagherpara',
                'chaugachha'    => 'Chaugachha',
                'jhikargachha'  => 'Jhikargachha',
                'jessore_sadar' => 'Jessore Sadar',
                'keshabpur'     => 'Keshabpur',
                'manirampur'    => 'Manirampur',
                'sharsha'       => 'Sharsha',
            ),
        ),

        'jhenaidah' => array(
            'label'  => 'Jhenaidah',
            'thanas' => array(
                'harinakunda'     => 'Harinakunda',
                'jhenaidah_sadar' => 'Jhenaidah Sadar',
                'kaliganj_jhn'    => 'Kaliganj',
                'kotchandpur'     => 'Kotchandpur',
                'maheshpur'       => 'Maheshpur',
                'shailkupa'       => 'Shailkupa',
            ),
        ),

        'khulna' => array(
            'label'  => 'Khulna',
            'thanas' => array(
                'batiaghata'    => 'Batiaghata',
                'dacope'        => 'Dacope',
                'daulatpur_khl' => 'Daulatpur',
                'dighalia'      => 'Dighalia',
                'dumuria'       => 'Dumuria',
                'khalishpur'    => 'Khalishpur',
                'khan_jahan_ali' => 'Khan Jahan Ali',
                'kotwali_khl'   => 'Kotwali',
                'koyra'         => 'Koyra',
                'paikgachha'    => 'Paikgachha',
                'phultala'      => 'Phultala',
                'rupsha'        => 'Rupsha',
                'sonadanga'     => 'Sonadanga',
                'terokhada'     => 'Terokhada',
            ),
        ),

        'kushtia' => array(
            'label'  => 'Kushtia',
            'thanas' => array(
                'bheramara'     => 'Bheramara',
                'daulatpur_kst' => 'Daulatpur',
                'khoksa'        => 'Khoksa',
                'kumarkhali'    => 'Kumarkhali',
                'kushtia_sadar' => 'Kushtia Sadar',
                'mirpur_kst'    => 'Mirpur',
            ),
        ),

        'magura' => array(
            'label'  => 'Magura',
            'thanas' => array(
                'magura_sadar'    => 'Magura Sadar',
                'mohammadpur_mg'  => 'Mohammadpur',
                'shalikha'        => 'Shalikha',
                'sreepur_mg'      => 'Sreepur',
            ),
        ),

        'meherpur' => array(
            'label'  => 'Meherpur',
            'thanas' => array(
                'gangni'          => 'Gangni',
                'meherpur_sadar'  => 'Meherpur Sadar',
                'mujibnagar'      => 'Mujibnagar',
            ),
        ),

        'narail' => array(
            'label'  => 'Narail',
            'thanas' => array(
                'kalia'        => 'Kalia',
                'lohagara_nr'  => 'Lohagara',
                'narail_sadar' => 'Narail Sadar',
            ),
        ),

        'satkhira' => array(
            'label'  => 'Satkhira',
            'thanas' => array(
                'assasuni'       => 'Assasuni',
                'debhata'        => 'Debhata',
                'kalaroa'        => 'Kalaroa',
                'kaliganj_stk'   => 'Kaliganj',
                'satkhira_sadar' => 'Satkhira Sadar',
                'shyamnagar'     => 'Shyamnagar',
                'tala'           => 'Tala',
            ),
        ),

        // =====================================================================
        // Sylhet Division
        // =====================================================================

        'habiganj' => array(
            'label'  => 'Habiganj',
            'thanas' => array(
                'ajmiriganj'      => 'Ajmiriganj',
                'bahubal'         => 'Bahubal',
                'baniachong'      => 'Baniachong',
                'chunarughat'     => 'Chunarughat',
                'habiganj_sadar'  => 'Habiganj Sadar',
                'lakhai'          => 'Lakhai',
                'madhabpur'       => 'Madhabpur',
                'nabiganj'        => 'Nabiganj',
                'sayestaganj'     => 'Sayestaganj',
            ),
        ),

        'moulvibazar' => array(
            'label'  => 'Moulvibazar',
            'thanas' => array(
                'barlekha'           => 'Barlekha',
                'juri'               => 'Juri',
                'kamalganj'          => 'Kamalganj',
                'kulaura'            => 'Kulaura',
                'moulvibazar_sadar'  => 'Moulvibazar Sadar',
                'rajnagar'           => 'Rajnagar',
                'sreemangal'         => 'Sreemangal',
            ),
        ),

        'sunamganj' => array(
            'label'  => 'Sunamganj',
            'thanas' => array(
                'bishwamvarpur'    => 'Bishwamvarpur',
                'chhatak'          => 'Chhatak',
                'derai'            => 'Derai',
                'dharampasha'      => 'Dharampasha',
                'dowarabazar'      => 'Dowarabazar',
                'jagannathpur'     => 'Jagannathpur',
                'jamalganj'        => 'Jamalganj',
                'sulla'            => 'Sulla',
                'sunamganj_sadar'  => 'Sunamganj Sadar',
                'tahirpur'         => 'Tahirpur',
                'south_sunamganj'  => 'South Sunamganj',
            ),
        ),

        'sylhet' => array(
            'label'  => 'Sylhet',
            'thanas' => array(
                'balaganj'       => 'Balaganj',
                'beanibazar'     => 'Beanibazar',
                'bishwanath'     => 'Bishwanath',
                'companiganj_sl' => 'Companiganj',
                'fenchuganj'     => 'Fenchuganj',
                'golapganj'      => 'Golapganj',
                'gowainghat'     => 'Gowainghat',
                'jaintiapur'     => 'Jaintiapur',
                'kanaighat'      => 'Kanaighat',
                'osmani_nagar'   => 'Osmani Nagar',
                'south_surma'    => 'South Surma',
                'sylhet_sadar'   => 'Sylhet Sadar',
                'zakiganj'       => 'Zakiganj',
            ),
        ),

        // =====================================================================
        // Mymensingh Division
        // =====================================================================

        'jamalpur' => array(
            'label'  => 'Jamalpur',
            'thanas' => array(
                'bakshiganj'      => 'Bakshiganj',
                'dewanganj'       => 'Dewanganj',
                'islampur'        => 'Islampur',
                'jamalpur_sadar'  => 'Jamalpur Sadar',
                'madarganj'       => 'Madarganj',
                'melandaha'       => 'Melandaha',
                'sarishabari'     => 'Sarishabari',
            ),
        ),

        'mymensingh' => array(
            'label'  => 'Mymensingh',
            'thanas' => array(
                'bhaluka'           => 'Bhaluka',
                'dhobaura'          => 'Dhobaura',
                'fulbaria'          => 'Fulbaria',
                'gaffargaon'        => 'Gaffargaon',
                'gauripur'          => 'Gauripur',
                'haluaghat'         => 'Haluaghat',
                'ishwarganj'        => 'Ishwarganj',
                'mymensingh_sadar'  => 'Mymensingh Sadar',
                'muktagachha'       => 'Muktagachha',
                'nandail'           => 'Nandail',
                'phulpur'           => 'Phulpur',
                'trishal'           => 'Trishal',
                'tarakanda'         => 'Tarakanda',
            ),
        ),

        'netrokona' => array(
            'label'  => 'Netrokona',
            'thanas' => array(
                'atpara'           => 'Atpara',
                'barhatta'         => 'Barhatta',
                'durgapur'         => 'Durgapur',
                'kalmakanda'       => 'Kalmakanda',
                'kendua'           => 'Kendua',
                'khaliajuri'       => 'Khaliajuri',
                'madan'            => 'Madan',
                'mohanganj'        => 'Mohanganj',
                'netrokona_sadar'  => 'Netrokona Sadar',
                'purbadhala'       => 'Purbadhala',
            ),
        ),

        'sherpur' => array(
            'label'  => 'Sherpur',
            'thanas' => array(
                'jhenaigati'    => 'Jhenaigati',
                'nakla'         => 'Nakla',
                'nalitabari'    => 'Nalitabari',
                'sherpur_sadar' => 'Sherpur Sadar',
                'sreebardi'     => 'Sreebardi',
            ),
        ),

        // =====================================================================
        // Rajshahi Division
        // =====================================================================

        'bogra' => array(
            'label'  => 'Bogra',
            'thanas' => array(
                'adamdighi'    => 'Adamdighi',
                'bogra_sadar'  => 'Bogra Sadar',
                'dhunat'       => 'Dhunat',
                'dhupchanchia' => 'Dhupchanchia',
                'gabtali'      => 'Gabtali',
                'kahaloo'      => 'Kahaloo',
                'nandigram'    => 'Nandigram',
                'sariakandi'   => 'Sariakandi',
                'shajahanpur'  => 'Shajahanpur',
                'sherpur_bg'   => 'Sherpur',
                'shibganj_bg'  => 'Shibganj',
                'sonatala'     => 'Sonatala',
            ),
        ),

        'chapainawabganj' => array(
            'label'  => 'Chapainawabganj',
            'thanas' => array(
                'bholahat'               => 'Bholahat',
                'chapainawabganj_sadar'  => 'Chapainawabganj Sadar',
                'gomastapur'             => 'Gomastapur',
                'nachole'                => 'Nachole',
                'shibganj_cpn'           => 'Shibganj',
            ),
        ),

        'joypurhat' => array(
            'label'  => 'Joypurhat',
            'thanas' => array(
                'akkelpur'        => 'Akkelpur',
                'joypurhat_sadar' => 'Joypurhat Sadar',
                'kalai'           => 'Kalai',
                'khetlal'         => 'Khetlal',
                'panchbibi'       => 'Panchbibi',
            ),
        ),

        'naogaon' => array(
            'label'  => 'Naogaon',
            'thanas' => array(
                'atrai'          => 'Atrai',
                'badalgachhi'    => 'Badalgachhi',
                'dhamoirhat'     => 'Dhamoirhat',
                'manda'          => 'Manda',
                'mahadebpur'     => 'Mahadebpur',
                'naogaon_sadar'  => 'Naogaon Sadar',
                'niamatpur'      => 'Niamatpur',
                'patnitala'      => 'Patnitala',
                'porsha'         => 'Porsha',
                'raninagar'      => 'Raninagar',
                'sapahar'        => 'Sapahar',
            ),
        ),

        'natore' => array(
            'label'  => 'Natore',
            'thanas' => array(
                'bagatipara'   => 'Bagatipara',
                'baraigram'    => 'Baraigram',
                'gurudaspur'   => 'Gurudaspur',
                'lalpur'       => 'Lalpur',
                'natore_sadar' => 'Natore Sadar',
                'singra'       => 'Singra',
                'naldanga'     => 'Naldanga',
            ),
        ),

        'pabna' => array(
            'label'  => 'Pabna',
            'thanas' => array(
                'atgharia'     => 'Atgharia',
                'bera'         => 'Bera',
                'bhangura'     => 'Bhangura',
                'chatmohar'    => 'Chatmohar',
                'faridpur_pb'  => 'Faridpur',
                'ishwardi'     => 'Ishwardi',
                'pabna_sadar'  => 'Pabna Sadar',
                'santhia'      => 'Santhia',
                'sujanagar'    => 'Sujanagar',
            ),
        ),

        'rajshahi' => array(
            'label'  => 'Rajshahi',
            'thanas' => array(
                'bagha'          => 'Bagha',
                'bagmara'        => 'Bagmara',
                'boalia'         => 'Boalia',
                'charghat'       => 'Charghat',
                'durgapur_rj'    => 'Durgapur',
                'godagari'       => 'Godagari',
                'matihar'        => 'Matihar',
                'mohanpur'       => 'Mohanpur',
                'paba'           => 'Paba',
                'puthia'         => 'Puthia',
                'rajpara'        => 'Rajpara',
                'shah_makhdum'   => 'Shah Makhdum',
                'tanore'         => 'Tanore',
            ),
        ),

        'sirajganj' => array(
            'label'  => 'Sirajganj',
            'thanas' => array(
                'belkuchi'        => 'Belkuchi',
                'chauhali'        => 'Chauhali',
                'kamarkhanda'     => 'Kamarkhanda',
                'kazipur'         => 'Kazipur',
                'raiganj'         => 'Raiganj',
                'shahzadpur'      => 'Shahzadpur',
                'sirajganj_sadar' => 'Sirajganj Sadar',
                'tarash'          => 'Tarash',
                'ullahpara'       => 'Ullahpara',
            ),
        ),

        // =====================================================================
        // Rangpur Division
        // =====================================================================

        'dinajpur' => array(
            'label'  => 'Dinajpur',
            'thanas' => array(
                'birampur'       => 'Birampur',
                'birganj'        => 'Birganj',
                'biral'          => 'Biral',
                'bochaganj'      => 'Bochaganj',
                'chirirbandar'   => 'Chirirbandar',
                'dinajpur_sadar' => 'Dinajpur Sadar',
                'fulbari_dnj'    => 'Fulbari',
                'ghoraghat'      => 'Ghoraghat',
                'hakimpur'       => 'Hakimpur',
                'kaharole'       => 'Kaharole',
                'khansama'       => 'Khansama',
                'nawabganj_dnj'  => 'Nawabganj',
                'parbatipur'     => 'Parbatipur',
            ),
        ),

        'gaibandha' => array(
            'label'  => 'Gaibandha',
            'thanas' => array(
                'fulchhari'       => 'Fulchhari',
                'gaibandha_sadar' => 'Gaibandha Sadar',
                'gobindaganj'     => 'Gobindaganj',
                'palashbari'      => 'Palashbari',
                'sadullapur'      => 'Sadullapur',
                'saghata'         => 'Saghata',
                'sundarganj'      => 'Sundarganj',
            ),
        ),

        'kurigram' => array(
            'label'  => 'Kurigram',
            'thanas' => array(
                'bhurungamari'   => 'Bhurungamari',
                'char_rajibpur'  => 'Char Rajibpur',
                'chilmari'       => 'Chilmari',
                'kurigram_sadar' => 'Kurigram Sadar',
                'nageshwari'     => 'Nageshwari',
                'phulbari_krg'   => 'Phulbari',
                'rajarhat'       => 'Rajarhat',
                'rajibpur'       => 'Rajibpur',
                'ulipur'         => 'Ulipur',
            ),
        ),

        'lalmonirhat' => array(
            'label'  => 'Lalmonirhat',
            'thanas' => array(
                'aditmari'           => 'Aditmari',
                'hatibandha'         => 'Hatibandha',
                'kaliganj_lmn'       => 'Kaliganj',
                'lalmonirhat_sadar'  => 'Lalmonirhat Sadar',
                'patgram'            => 'Patgram',
            ),
        ),

        'nilphamari' => array(
            'label'  => 'Nilphamari',
            'thanas' => array(
                'dimla'             => 'Dimla',
                'domar'             => 'Domar',
                'jaldhaka'          => 'Jaldhaka',
                'kishoreganj_nlp'   => 'Kishoreganj',
                'nilphamari_sadar'  => 'Nilphamari Sadar',
                'saidpur'           => 'Saidpur',
            ),
        ),

        'panchagarh' => array(
            'label'  => 'Panchagarh',
            'thanas' => array(
                'atwari'           => 'Atwari',
                'boda'             => 'Boda',
                'debiganj'         => 'Debiganj',
                'panchagarh_sadar' => 'Panchagarh Sadar',
                'tetulia'          => 'Tetulia',
            ),
        ),

        'rangpur' => array(
            'label'  => 'Rangpur',
            'thanas' => array(
                'badarganj'      => 'Badarganj',
                'gangachara'     => 'Gangachara',
                'kaunia'         => 'Kaunia',
                'mithapukur'     => 'Mithapukur',
                'pirgachha'      => 'Pirgachha',
                'pirganj'        => 'Pirganj',
                'rangpur_sadar'  => 'Rangpur Sadar',
                'taraganj'       => 'Taraganj',
            ),
        ),

        'thakurgaon' => array(
            'label'  => 'Thakurgaon',
            'thanas' => array(
                'baliadangi'       => 'Baliadangi',
                'haripur'          => 'Haripur',
                'pirganj_thk'      => 'Pirganj',
                'ranisankail'      => 'Ranisankail',
                'thakurgaon_sadar' => 'Thakurgaon Sadar',
            ),
        ),

    );
}
