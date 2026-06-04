<?php

namespace Database\Seeders;

use App\Models\Xassida;
use Illuminate\Database\Seeder;

class XassidaSeeder extends Seeder
{
    public function run(): void
    {
        $arabicOrdinals = [
            'الْأَوَّل', 'الثَّانِي', 'الثَّالِث', 'الرَّابِع', 'الْخَامِس',
            'السَّادِس', 'السَّابِع', 'الثَّامِن', 'التَّاسِع', 'الْعَاشِر',
            'الْحَادِي عَشَر', 'الثَّانِي عَشَر', 'الثَّالِث عَشَر', 'الرَّابِع عَشَر', 'الْخَامِس عَشَر',
            'السَّادِس عَشَر', 'السَّابِع عَشَر', 'الثَّامِن عَشَر', 'التَّاسِع عَشَر', 'الْعِشْرُون',
            'الْحَادِي وَالْعِشْرُون', 'الثَّانِي وَالْعِشْرُون', 'الثَّالِث وَالْعِشْرُون',
            'الرَّابِع وَالْعِشْرُون', 'الْخَامِس وَالْعِشْرُون', 'السَّادِس وَالْعِشْرُون',
            'السَّابِع وَالْعِشْرُون', 'الثَّامِن وَالْعِشْرُون', 'التَّاسِع وَالْعِشْرُون', 'الثَّلَاثُون',
        ];

        $juzFiles = [
            '01-quran1-ar.pdf',  '02-quran2-ar.pdf',  '03-quran3-ar.pdf',  '04-quran4-ar.pdf',
            '05-quran5-ar.pdf',  '06-quran6-ar.pdf',  '07-quran7-ar.pdf',  '08-quran8-ar.pdf',
            '09-quran9-ar.pdf',  '10-quran10-ar.pdf', '11-quran11-ar.pdf', '12-quran12-ar.pdf',
            '13-quran13-ar.pdf', '14-quran14-ar.pdf', '15-quran15-ar.pdf', '16-quran16-ar.pdf',
            '17-quran17-ar.pdf', '18-quran18-ar.pdf', '19-quran19-ar.pdf', '20-quran20-ar.pdf',
            '21-quran21-ar.pdf', '22-quran22-ar.pdf', '23-quran23-ar.pdf', '24-quran24-ar.pdf',
            '25-quran25-ar.pdf', '26-quran26-ar.pdf', '27-quran27-ar.pdf', '28-quran28-ar.pdf',
            '29-quran29-ar.pdf', '30-quran30-ar.pdf',
        ];

        foreach ($juzFiles as $i => $file) {
            $n = $i + 1;
            Xassida::updateOrCreate(['id' => "juz-static-{$n}"], [
                'titre'       => "JUZ {$n}",
                'titre_arabe' => "الْجُزْءُ {$arabicOrdinals[$i]}",
                'auteur'      => 'القرآن الكريم',
                'description' => "Juz {$n} du Saint Coran",
                'categorie'   => 'JUZ',
                'poeme'       => '',
                'versets'     => [],
                'pdfs'        => [['id' => "juz-pdf-{$n}", 'name' => $file, 'url' => "/JUZ/{$file}"]],
            ]);
        }

        $drussFiles = [
            ['file' => 'Ahbabtou+fatahan.pdf',                                        'titre' => 'Ahbabtou Fatahan',                    'titre_arabe' => 'أَحْبَبْتُ فَتَحَاً'],
            ['file' => 'Ahmadu_Muhniyan_3.pdf',                                       'titre' => 'Ahmadu Muhniyan',                     'titre_arabe' => 'أَحْمَدُ مُهْنِيَان'],
            ['file' => 'Alaa_Inani_Ousni_Alaa_Inani_Arju_Ed_Srn_Saliou_Mbacke.pdf', 'titre' => 'Alaa Inani Ousni',                    'titre_arabe' => 'عَلَى إِنَانِي أُسْنِي'],
            ['file' => 'Allaahu_min_kulli_kariimin_2.pdf',                            'titre' => 'Allaahu Min Kulli Kariim',            'titre_arabe' => 'اللَّهُ مِنْ كُلِّ كَرِيمٍ'],
            ['file' => 'Astaghfiroulaha bihi Wolof.pdf',                              'titre' => 'Astaghfiroulaha Bihi (Wolof)',        'titre_arabe' => 'أَسْتَغْفِرُ اللَّهَ بِهِ وُولُوف'],
            ['file' => 'Astaghfiroulaha bihi.pdf',                                    'titre' => 'Astaghfiroulaha Bihi',                'titre_arabe' => 'أَسْتَغْفِرُ اللَّهَ بِهِ'],
            ['file' => 'Astaxfirul Laaha Bihii.pdf',                                  'titre' => 'Astaxfirul Laaha Bihii',              'titre_arabe' => 'أَسْتَغْفِرُ اللَّهَ بِهِ'],
            ['file' => 'Ayassa_Minilahu_3.pdf',                                       'titre' => 'Ayassa Minilahu',                     'titre_arabe' => 'أَيَاسَ مِنِ اللَّهُ'],
            ['file' => 'Calendrier khassida.pdf',                                     'titre' => 'Calendrier Xassida',                  'titre_arabe' => 'كَالَانْدِرْيَه خَاسِيدَ'],
            ['file' => 'Jaalibatul_Maraaxib_6.pdf',                                   'titre' => 'Jaalibatul Maraaxib',                 'titre_arabe' => 'جَالِبَةُ الْمَرَاتِب'],
            ['file' => 'Jawartul_Laha_10.pdf',                                        'titre' => 'Jawartul Laha',                       'titre_arabe' => 'جَوْهَرَةُ اللَّهَاء'],
            ['file' => 'Jawartul_Laha_2.pdf',                                         'titre' => 'Jawartul Laha 2',                     'titre_arabe' => 'جَوْهَرَةُ اللَّهَاء ٢'],
            ['file' => 'Khassida taani.pdf',                                          'titre' => 'Khassida Taani',                      'titre_arabe' => 'خَاسِيدَ تَانِي'],
            ['file' => 'Khoutbay Aldjuma yi.pdf',                                     'titre' => 'Khoutbay Aldjuma Yi',                 'titre_arabe' => 'خُطَبُ الْجُمُعَة'],
            ['file' => 'Kun Kaatiman.pdf',                                            'titre' => 'Kun Kaatiman',                        'titre_arabe' => 'كُنْ كَاتِمَاً'],
            ['file' => 'Lam yabdu Mislul MUSTAFAA.pdf',                               'titre' => 'Lam Yabdu Mislul Mustafa',            'titre_arabe' => 'لَمْ يَبْدُ مِثْلُ الْمُصْطَفَى'],
            ['file' => 'Layssa Birrou.pdf',                                           'titre' => 'Layssa Birrou',                       'titre_arabe' => 'لَيْسَ الْبِرُّ'],
            ['file' => 'Maddal habirou-Lissanou.pdf',                                 'titre' => 'Maddal Habirou Lissanou',             'titre_arabe' => 'مَدُّ الْحَبُورِ لِلِّسَانِ'],
            ['file' => 'Mafaatihul Bishri 2.pdf',                                     'titre' => 'Mafaatihul Bishri 2',                 'titre_arabe' => 'مَفَاتِيحُ الْبِشْرِ ٢'],
            ['file' => 'Mafaatihul Bishri.pdf',                                       'titre' => 'Mafaatihul Bishri',                   'titre_arabe' => 'مَفَاتِيحُ الْبِشْرِ'],
            ['file' => 'Mafaatihul_Jinaan_3.pdf',                                     'titre' => 'Mafaatihul Jinaan',                   'titre_arabe' => 'مَفَاتِيحُ الْجِنَان'],
            ['file' => 'Mafatihul bishri_kubra.pdf',                                  'titre' => 'Mafatihul Bishri Kubra',              'titre_arabe' => 'مَفَاتِيحُ الْبِشْرِ الْكُبْرَى'],
            ['file' => 'Mashrabu_Saafi_1.pdf',                                        'titre' => 'Mashrabu Saafi',                      'titre_arabe' => 'الْمَشْرَبُ الصَّافِي'],
            ['file' => 'Matlabul_Fawzeyni_5.pdf',                                     'titre' => 'Matlabul Fawzeyni',                   'titre_arabe' => 'مَطْلَبُ الْفَوْزَيْنِ'],
            ['file' => 'Matlabush_Shifa-i_6.pdf',                                     'titre' => "Matlabush Shifa'i",                   'titre_arabe' => 'مَطْلَبُ الشِّفَاء'],
            ['file' => 'Mawahibu_nafih_5.pdf',                                        'titre' => 'Mawahibu Nafih',                      'titre_arabe' => 'مَوَاهِبُ النَّافِح'],
            ['file' => 'Mawahibu_xudoss_2.pdf',                                       'titre' => 'Mawahibu Xudoss',                     'titre_arabe' => 'مَوَاهِبُ الْقُدُوس'],
            ['file' => 'Midaadii.pdf',                                                'titre' => 'Midaadii',                            'titre_arabe' => 'مِدَادِي'],
            ['file' => 'Minal-Lawhil-Mahfuzin.pdf',                                   'titre' => 'Minal Lawhil Mahfuzin',               'titre_arabe' => 'مِنَ اللَّوْحِ الْمَحْفُوظِ'],
            ['file' => 'Munawwirus-Sudoor-ar.pdf',                                    'titre' => 'Munawwirus Sudoor',                   'titre_arabe' => 'مُنَوِّرُ الصُّدُور'],
            ['file' => 'Muqadammatul_Amdah_3.pdf',                                    'titre' => 'Muqadammatul Amdah',                  'titre_arabe' => 'مُقَدَّمَةُ الْمَدْح'],
            ['file' => 'Nafahanii.pdf',                                               'titre' => 'Nafahanii',                           'titre_arabe' => 'نَفَحَانِي'],
            ['file' => 'Nuru_Dareyni_1.pdf',                                          'titre' => 'Nuru Dareyni',                        'titre_arabe' => 'نُورُ الدَّارَيْنِ'],
            ['file' => 'Qunoot fadjar.pdf',                                           'titre' => 'Qunoot Fadjar',                       'titre_arabe' => 'قُنُوتُ الْفَجْرِ'],
            ['file' => 'Qunoot.pdf',                                                  'titre' => 'Qunoot',                              'titre_arabe' => 'قُنُوت'],
            ['file' => 'Rabbii bimaa yasrahu.pdf',                                    'titre' => 'Rabbi Bimaa Yasrahu',                 'titre_arabe' => 'رَبِّي بِمَا يَسْرَحُ'],
            ['file' => 'Sindidi_5.pdf',                                               'titre' => 'Sindidi',                             'titre_arabe' => 'سِنْدِيدِي'],
            ['file' => 'Tuhfatul_Mutadarihina_8.pdf',                                 'titre' => 'Tuhfatul Mutadarihina',               'titre_arabe' => 'تُحْفَةُ الْمُتَضَارِهِينَ'],
            ['file' => 'mouxadimatoul Xidma.pdf',                                     'titre' => 'Mouxadimatoul Xidma',                 'titre_arabe' => 'مُقَدِّمَةُ الْخِدْمَة'],
            ['file' => 'Muqaddimatoul Xidma (VARIANTE).pdf',                          'titre' => 'Muqaddimatoul Xidma (variante)',      'titre_arabe' => 'مُقَدِّمَةُ الْخِدْمَة بِيَدِ سَرَج'],
        ];

        foreach ($drussFiles as $i => $f) {
            $id = 'static-druuss-' . ($i + 1);
            Xassida::updateOrCreate(['id' => $id], [
                'titre'       => $f['titre'],
                'titre_arabe' => $f['titre_arabe'],
                'auteur'      => 'Cheikh Ahmadou Bamba',
                'description' => '',
                'categorie'   => 'Druuss',
                'poeme'       => '',
                'versets'     => [],
                'pdfs'        => [['id' => "{$id}-pdf", 'name' => $f['file'], 'url' => '/DRUSS/' . rawurlencode($f['file'])]],
            ]);
        }

        $xamxamFiles = [
            ['file' => 'CauseriesAspirantVeridique.pdf',  'titre' => "Causeries de l'Aspirant Véritable", 'titre_arabe' => 'خُطَبُ الْمُرِيدِ الصَّادِق'],
            ['file' => 'DiazbouMurid-fr.pdf',            'titre' => 'Diazbou Murid',                     'titre_arabe' => 'دِيَاظَبُو مُرِيد'],
            ['file' => 'Jawharou-n-nafis-fr.pdf',        'titre' => 'Jawharou Nafis',                    'titre_arabe' => 'جَوْهَرُ النَّفِيس'],
            ['file' => 'Khouratu ayni (arabe).pdf',      'titre' => 'Khouratu Ayni',                     'titre_arabe' => 'خُورَةُ عَيْنِي'],
            ['file' => 'masalikul jinan arab.pdf',       'titre' => 'Masalikul Jinan',                   'titre_arabe' => 'مَسَالِكُ الْجِنَان'],
            ['file' => 'Mawahibu_xudoss_2.pdf',          'titre' => 'Mawahibu Xudoss',                   'titre_arabe' => 'مَوَاهِبُ الْقُدُوس'],
            ['file' => 'Tazawwudou-sh-subban-fr.pdf',    'titre' => 'Tazawwudou Shubban',                'titre_arabe' => 'تَزَوَّدُوا الشُّبَّان'],
            ['file' => 'tazawwud-ss-sighar.pdf',         'titre' => 'Tazawwud Sighar',                   'titre_arabe' => 'تَزَوَّدُ الصِّغَار'],
            ['file' => 'Téere lénn ci ñaani att mi.pdf', 'titre' => 'Téere Lénn Ci Ñaani Att',           'titre_arabe' => 'تِيرِ لِنَّ سِي ناني آت'],
        ];

        foreach ($xamxamFiles as $i => $f) {
            $id = 'static-xam-xam-' . ($i + 1);
            Xassida::updateOrCreate(['id' => $id], [
                'titre'       => $f['titre'],
                'titre_arabe' => $f['titre_arabe'],
                'auteur'      => 'Cheikh Ahmadou Bamba',
                'description' => '',
                'categorie'   => 'Xam Xam',
                'poeme'       => '',
                'versets'     => [],
                'pdfs'        => [['id' => "{$id}-pdf", 'name' => $f['file'], 'url' => '/XAM%20XAM/' . rawurlencode($f['file'])]],
            ]);
        }
    }
}
