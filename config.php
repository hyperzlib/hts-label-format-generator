<?php 
/** TODO:
 *   词性部分仍需补充
 */
return [
    'switch' => [
        'generate_label' => true,
        'generate_qst' => true,
    ],
    'static_separator' => [
        'p' => ['', '@', '^', '-', '+', '='],
    ],
    'separator_range' => ['-', '+', '=', '!', '@', '#', '$', '^', '&', '~', '|', '[', ']', '(', ')', '<', '>'],
    'part' => [
        'p' => [
            ['s', '音素类型(b:爆破, p:等待, s:无声音, c:元音, v:辅音)', 'C', 'phone_language_independent_pause'],
            ['s', '上上个音素', 'LL', 'phone'],
            ['s', '上个音素', 'L', 'phone'],
            ['s', '当前音素', 'C', 'phone'],
            ['s', '下个音素', 'R', 'phone'],
            ['s', '下下个音素', 'RR', 'phone'],
            ['d', '上上个音的表情', 'LL', 'phone_express'],
            ['d', '上个音的表情', 'L', 'phone_express'],
            ['d', '当前音的表情', 'C', 'phone_express'],
            ['d', '下个音的表情', 'R', 'phone_express'],
            ['d', '下下个音的表情', 'RR', 'phone_express'],
            ['d', '上上个音的音调（五度标记法）', 'LL', 'phone_rhythm'],
            ['d', '上个音的音调（五度标记法）', 'L', 'phone_rhythm'],
            ['d', '当前音的音调（五度标记法）', 'C', 'phone_rhythm'],
            ['d', '下个音的音调（五度标记法）', 'R', 'phone_rhythm'],
            ['d', '下下个音的音调（五度标记法）', 'RR', 'phone_rhythm'],
        ],
        'a' => [
            ['d', '上一个音符/词语距离本句开头的音符/词语数', 'L', 'fw_pos_in_sentence'],
            ['d', '上一个音符/词语距离本句结尾的音符/词语数', 'L', 'bw_pos_in_sentence'],
            ['d', '上一个音素距离音符/词语开头的音素数', 'L', 'fw_pos_in_note'],
            ['d', '上一个音素距离音符/词语结尾的音素数', 'L', 'bw_pos_in_note'],
            ['s', '上一个音符/词语的词性', 'L', 'note_type'],
            ['s', '上一个音符/词语的音素数', 'L', 'note_phone_num'],
        ],
        'b' => [
            ['d', '当前音符/词语距离本句开头的音符/词语数', 'C', 'fw_pos_in_sentence'],
            ['d', '当前音符/词语距离本句结尾的音符/词语数', 'C', 'bw_pos_in_sentence'],
            ['d', '当前音符/词语距离本句开头的时间（10毫秒）', 'C', 'fw_pos_in_sentence(ms)'],
            ['d', '当前音符/词语距离本句结尾的时间（10毫秒）', 'C', 'bw_pos_in_sentence(ms)'],
            ['d', '当前音素距离音符/词语开头的音素数', 'C', 'fw_pos_in_note'],
            ['d', '当前音素距离音符/词语结尾的音素数', 'C', 'bw_pos_in_note'],
            ['d', '当前音素距离本句开头的音素数', 'C', 'fw_pos_in_sentence_phone'],
            ['d', '当前音素距离本句结尾的音素数', 'C', 'bw_pos_in_sentence_phone'],
            ['s', '当前音符/词语的词性', 'C', 'note_type'],
            ['s', '当前音符/词语的音素数', 'C', 'note_phone_num'],
        ],
        'c' => [
            ['d', '下一个音距离本句开头的音素数', 'R', 'fw_pos_in_sentence'],
            ['d', '下一个音距离本句结尾的音素数', 'R', 'bw_pos_in_sentence'],
            ['d', '下一个音距离音符开头的音素数', 'R', 'fw_pos_in_note'],
            ['d', '下一个音距离音符结尾的音素数', 'R', 'bw_pos_in_note'],
            ['s', '下一个音符/词语的词性', 'R', 'note_type'],
            ['s', '下一个音符/词语的音素数', 'R', 'note_phone_num'],
        ],
        'd' => [
            ['d', '上一个音的音长(10ms)', 'L', 'note_length(ms)'],
            ['s', '上一个音的绝对音高(国际音高表示法)', 'L', 'note_abs_scale'],
            ['d', '上一个音的BPM', 'L', 'note_tempo'],
            ['s', '上一个音的语言', 'L', 'language'],
        ],
        'e' => [
            ['d', '当前音的音长(10ms)', 'C', 'note_length(ms)'],
            ['s', '当前音的绝对音高(国际音高表示法)', 'C', 'note_abs_scale'],
            ['d', '当前音的BPM', 'C', 'note_tempo'],
            ['s', '当前音的语言', 'C', 'language'],
            ['d', '与前一个音的音高差(正，半音)', 'C', 'note_left_rel_scale(up)'],
            ['d', '与后一个音的音高差(正，半音)', 'C', 'note_right_rel_scale(up)'],
            ['d', '与前一个音的音高差(负，半音)', 'C', 'note_left_rel_scale(down)'],
            ['d', '与后一个音的音高差(负，半音)', 'C', 'note_right_rel_scale(down)'],

        ],
        'f' => [
            ['d', '下一个音的音长(10ms)', 'L', 'note_length(ms)'],
            ['s', '下一个音的绝对音高(国际音高表示法)', 'R', 'note_abs_scale'],
            ['d', '下一个音的BPM', 'R', 'note_tempo'],
            ['s', '下一个音的语言', 'R', 'language'],
        ],
    ],
    'map' => [
        'phone_language_independent_pause' => [
            'pair' => [
                'Silence' => 's',
                'Pause' => 'p',
                'Break' => 'b',
                'Consonant' => 'c',
                'Vowel' => 'v',
            ],
        ],
        'phone' => [
            'pair' => [
                //所有音列表
                'Voiced_Sounds' => ['a', 'o', 'e', 'eh', 'i', 'u', 'v', 'i', 'ii', 'iii', 'er', 'ai', 'ei', 'ao', 'ou', 'ia', 'ie', 'ua', 'uo', 've', 'iao', 'iou', 'uai', 'uei', 'an', 'en', 'in', 'vn', 'ian', 'uan', 'uen', 'van', 'ang', 'eng', 'ing', 'ong', 'iang', 'iong', 'uang', 'ueng', 'b', 'd', 'g', 'm', 'n', 'l', 'j', 'zh', 'z', 'w', 'y', 'r'],
                'Unvoiced_Sounds' => ['p', 't', 'k', 'f', 'h', 'x', 'ch', 'sh', 'c', 's'],
                'Vowels' => ['a', 'o', 'e', 'eh', 'i', 'u', 'v', 'i', 'ii', 'iii', 'er', 'ai', 'ei', 'ao', 'ou', 'ia', 'ie', 'ua', 'uo', 've', 'iao', 'iou', 'uai', 'uei', 'an', 'en', 'in', 'vn', 'ian', 'uan', 'uen', 'van', 'ang', 'eng', 'ing', 'ong', 'iang', 'iong', 'uang', 'ueng'],
                //辅音列表
                'Voiced_Consonants' => ['b', 'd', 'g', 'm', 'n', 'l', 'j', 'zh', 'z', 'w', 'y', 'r'],
                'Unvoiced_Consonants' => ['p', 't', 'k', 'f', 'h', 'x', 'ch', 'sh', 'c', 's'],
                'Plosive_Consonant' => ['b', 'd', 'g', 'p', 't', 'k'],
                'Aspirated_Plosive_Consonant' => ['b', 'd', 'g'],
                'Unaspirated_Plosive_Consonant' => ['p', 't', 'k'],
                'Affricate_Consonant' => ['z', 'zh', 'j', 'c', 'ch', 'q'],
                'Aspirated_Affricate_Consonant' => ['z', 'zh', 'j'],
                'Unaspirated_Affricate_consonant' => ['c', 'ch', 'q'],
                'Fricative_Consonants' => ['f', 's', 'sh', 'x', 'h', 'r', 'k'],
                'Voiceless_Fricative_Consonants' => ['f', 's', 'sh', 'x'],
                'Voice_Fricative_Consonants' => ['r', 'k'],
                'Vowel_Consonants' => ['w', 'y'],
                'Nasal_Consonants' => ['m', 'n', 'l'],
                'Silent' => ['sil', 'pau'],
                //元音列表
                'TypeA_Vowels' => ['a', 'ia', 'an', 'ang', 'ai', 'ua', 'ao'],
                'TypeE_Vowels' => ['e', 'ei', 'uei', 'er'],
                'TypeEH_Vowels' => ['ie', 've', 'eh'],
                'TypeI_Vowels' => ['i', 'ai', 'ei', 'uei', 'ia', 'ian', 'iang', 'iao', 'ie', 'in', 'ing', 'iong', 'iou'],
                'TypeO_Vowels' => ['o', 'ao', 'uo', 'ou', 'ong', 'iou'],
                'TypeU_Vowels' => ['u', 'ua', 'uan', 'uang', 'uen', 'ueng', 'uo', 'uei', 'iou', 'ou'],
                'TypeV_Vowels' => ['v', 'vn', 've', 'van'],
                'Nasal_Vowel' => ['an', 'ian', 'uan', 'van', 'en', 'in', 'uen', 'vn', 'ang', 'iang', 'uang', 'eng', 'ing', 'ueng', 'ong', 'iong'],
                'Anterior_Nasal_Vowel' => ['an', 'ian', 'uan', 'van', 'en', 'in', 'uen', 'vn'],
                'Posterior_Nasal_Vowel' => ['ang', 'eng', 'ing', 'ong', 'iang', 'iong', 'uang', 'ueng'],
            ],
            'list' => ['a', 'o', 'e', 'eh', 'i', 'u', 'v', 'i', 'ii', 'iii', 'er', 'ai', 'ei', 'ao', 'ou', 'ia', 'ie', 'ua', 'uo', 've', 'iao', 'iou', 'uai', 'uei', 'an', 'en', 'in', 'vn', 'ian', 'uan', 'uen', 'van', 'ang', 'eng', 'ing', 'ong', 'iang', 'iong', 'uang', 'ueng', 'b', 'd', 'g', 'm', 'n', 'l', 'j', 'zh', 'z', 'w', 'y', 'r', 'p', 't', 'k', 'f', 'h', 'x', 'ch', 'sh', 'c', 's'],
        ],
        'phone_express' => [
            'pair' => [
                'Normal' => '0',
            ],
        ],
        'phone_rhythm' => [
            'pair' => [
                'Yinping' => '55',
                'Yangping' => '35',
                'Shang' => '214',
                'Qu' => '51',
                'Qing' => ['10', '20', '30', '40'],
                'Yinping_Qing' => '20',
                'Yangping_Qing' => '30',
                'Shang_Qing' => '40',
                'Qu_Qing' => '10',
            ],
        ],
        'language' => [
            'pair' => [
                'English' => 'ENG',
                'Mandarin_Chinese' => ['CHM', 'CHN'],  //普通话
                'Taiwanese_Chinese' => ['CHT', 'TWN'], //台湾语
                'Cantonese_Chinese' => ['CHC', 'CTN'], //粤语
                'Japanese' => 'JPN',
            ],
            'pair_separator' => '=',
        ],
        'fw_pos_in_note' => [
            'range' => [
                'start' => 0,
                'end' => 9,
            ],
        ],
        'bw_pos_in_note' => [
            'range' => [
                'start' => 0,
                'end' => 9,
            ],
        ],
        'fw_pos_in_sentence' => [
            'range' => [
                'start' => 0,
                'end' => 49,
            ],
        ],
        'bw_pos_in_sentence' => [
            'range' => [
                'start' => 0,
                'end' => 49,
            ],
        ],
        'fw_pos_in_sentence_phone' => [
            'range' => [
                'start' => 0,
                'end' => 99,
            ],
        ],
        'bw_pos_in_sentence_phone' => [
            'range' => [
                'start' => 0,
                'end' => 99,
            ],
        ],
        'note_length(ms)' => [
            'range' => [
                [
                    'start' => 0,
                    'end' => 99,
                ],
                [
                    'start' => 100,
                    'end' => 299,
                    'step' => 5,
                ],
                [
                    'start' => 300,
                    'end' => 999,
                    'step' => 10,
                ]
            ],
        ],
        'fw_pos_in_sentence(ms)' => [
            'range' => [
                [
                    'start' => 0,
                    'end' => 99,
                ],
                [
                    'start' => 100,
                    'end' => 299,
                    'step' => 5,
                ],
                [
                    'start' => 300,
                    'end' => 999,
                    'step' => 10,
                ],
                [
                    'start' => 1000,
                    'end' => 4999, 
                    'step' => 50,
                ],
            ],
        ],
        'bw_pos_in_sentence(ms)' => [
            'range' => [
                [
                    'start' => 0,
                    'end' => 99,
                ],
                [
                    'start' => 100,
                    'end' => 299,
                    'step' => 5,
                ],
                [
                    'start' => 300,
                    'end' => 999,
                    'step' => 10,
                ],
                [
                    'start' => 1000,
                    'end' => 4999, 
                    'step' => 50,
                ],
            ],
        ],
        'note_type' => [
            'pair' => [
                
            ],
        ],
        'note_phone_num' => [
            'range' => [
                'start' => 0,
                'end' => 49,
            ]
        ],
        'note_abs_scale' => [
            'scaleRange' => [
                'start' => 'C1',
                'end' => 'B6',
            ],
        ],
        'note_tempo' => [
            'range' => [
                [
                    'start' => 40,
                    'end' => 219,
                ],
                [
                    'start' => 220,
                    'end' => 349,
                    'step' => 5,
                ],
                [
                    'start' => 350,
                    'end' => 499,
                    'step' => 10,
                ],
            ],
        ],
        'note_left_rel_scale(up)' => [
            'range' => [
                'start' => 0,
                'end' => 24,
            ],
        ],
        'note_right_rel_scale(up)' => [
            'range' => [
                'start' => 0,
                'end' => 24,
            ],
        ],
        'note_left_rel_scale(down)' => [
            'range' => [
                'start' => 0,
                'end' => 24,
            ],
        ],
        'note_right_rel_scale(down)' => [
            'range' => [
                'start' => 0,
                'end' => 24,
            ],
        ],
    ],
];
?>