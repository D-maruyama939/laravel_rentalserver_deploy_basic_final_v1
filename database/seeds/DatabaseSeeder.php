<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 都道府県
        $prefectures = [
          [
              'id' => 1,
              'prefecture' => '北海道',
              
          ],
          [
              'id' => 2,
              'prefecture' => '青森県',
              
          ],
          [
              'id' => 3,
              'prefecture' => '岩手県',
              
          ],
          [
              'id' => 4,
              'prefecture' => '秋田県',
              
          ],
          [
              'id' => 5,
              'prefecture' => '宮城県',
              
          ],
          [
              'id' => 6,
              'prefecture' => '山形県',
              
          ],
          [
              'id' => 7,
              'prefecture' => '福島県',
              
          ],
          [
              'id' => 8,
              'prefecture' => '茨城県',
              
          ],
          [
              'id' => 9,
              'prefecture' => '栃木県',
              
          ],
          [
              'id' => 10,
              'prefecture' => '群馬県',
              
          ],
          [
              'id' => 11,
              'prefecture' => '千葉県',
              
          ],
          [
              'id' => 12,
              'prefecture' => '埼玉県',
              
          ],
          [
              'id' => 13,
              'prefecture' => '東京都',
              
          ],
          [
              'id' => 14,
              'prefecture' => '神奈川県',
              
          ],
          [
              'id' => 15,
              'prefecture' => '山梨県',
              
          ],
          [
              'id' => 16,
              'prefecture' => '新潟県',
              
          ],
          [
              'id' => 17,
              'prefecture' => '富山県',
              
          ],
          [
              'id' => 18,
              'prefecture' => '石川県',
              
          ],
          [
              'id' => 19,
              'prefecture' => '福井県',
              
          ],
          [
              'id' => 20,
              'prefecture' => '長野県',
              
          ],
          [
              'id' => 21,
              'prefecture' => '静岡県',
              
          ],
          [
              'id' => 22,
              'prefecture' => '岐阜県',
              
          ],
          [
              'id' => 23,
              'prefecture' => '愛知県',
              
          ],
          [
              'id' => 24,
              'prefecture' => '三重県',
              
          ],
          [
              'id' => 25,
              'prefecture' => '和歌山県',
              
          ],
          [
              'id' => 26,
              'prefecture' => '滋賀県',
              
          ],
          [
              'id' => 27,
              'prefecture' => '京都府',
              
          ],
          [
              'id' => 28,
              'prefecture' => '奈良県',
              
          ],
          [
              'id' => 29,
              'prefecture' => '大阪府',
              
          ],
          [
              'id' => 30,
              'prefecture' => '兵庫県',
              
          ],
          [
              'id' => 31,
              'prefecture' => '岡山県',
              
          ],
          [
              'id' => 32,
              'prefecture' => '広島県',
              
          ],
          [
              'id' => 33,
              'prefecture' => '鳥取県',
              
          ],
          [
              'id' => 34,
              'prefecture' => '島根県',
              
          ],
          [
              'id' => 35,
              'prefecture' => '山口県',
              
          ],
          [
              'id' => 36,
              'prefecture' => '香川県',
              
          ],
          [
              'id' => 37,
              'prefecture' => '徳島県',
              
          ],
          [
              'id' => 38,
              'prefecture' => '愛媛県',
              
          ],
          [
              'id' => 39,
              'prefecture' => '高知県',
              
          ],
          [
              'id' => 40,
              'prefecture' => '福岡県',
              
          ],
          [
              'id' => 41,
              'prefecture' => '大分県',
              
          ],
          [
              'id' => 42,
              'prefecture' => '佐賀県',
              
          ],
          [
              'id' => 43,
              'prefecture' => '長崎県',
              
          ],
          [
              'id' => 44,
              'prefecture' => '熊本県',
              
          ],
          [
              'id' => 45,
              'prefecture' => '宮崎県',
              
          ],
          [
              'id' => 46,
              'prefecture' => '鹿児島県',
              
          ],
          [
              'id' => 47,
              'prefecture' => '沖縄県',
              
          ],
      ];
 
      foreach($prefectures as $prefecture){
          DB::table('prefectures')->insert($prefecture);
      }
      
    //   タググループ
      $tag_groups = [
          [
              'id' => 1,
              'group_name' => '年代',
          ],
          [
              'id' => 2,
              'group_name' => 'シーン・シチュエーション',
          ],
          [
              'id' => 3,
              'group_name' => '目的・行き先',
          ],
          [
              'id' => 4,
              'group_name' => '移動手段',
          ],
      ];
 
      foreach($tag_groups as $tag_group){
          DB::table('tag_groups')->insert($tag_group);
      }
      
    //   タグ
      $tags = [
          [
              'id' => 1,
              'group_id' => 1,
              'tag_name' => '10代後半',
          ],
          [
              'id' => 2,
              'group_id' => 1,
              'tag_name' => '20代',
          ],
          [
              'id' => 3,
              'group_id' => 1,
              'tag_name' => '30代',
          ],
          [
              'id' => 4,
              'group_id' => 1,
              'tag_name' => '40代',
          ],
          [
              'id' => 5,
              'group_id' => 1,
              'tag_name' => '50代',
          ],
          [
              'id' => 6,
              'group_id' => 1,
              'tag_name' => '60代～',
          ],
          [
              'id' => 7,
              'group_id' => 1,
              'tag_name' => '全年齢',
          ],
          [
              'id' => 8,
              'group_id' => 2,
              'tag_name' => '雨の日・悪天候',
          ],
          [
              'id' => 9,
              'group_id' => 2,
              'tag_name' => '春',
          ],
          [
              'id' => 10,
              'group_id' => 2,
              'tag_name' => '夏',
          ],
          [
              'id' => 11,
              'group_id' => 2,
              'tag_name' => '秋',
          ],
          [
              'id' => 12,
              'group_id' => 2,
              'tag_name' => '冬',
          ],
          [
              'id' => 13,
              'group_id' => 2,
              'tag_name' => 'オールシーズン',
          ],
          [
              'id' => 14,
              'group_id' => 2,
              'tag_name' => 'デート',
          ],
          [
              'id' => 15,
              'group_id' => 2,
              'tag_name' => 'ファミリー',
          ],
          [
              'id' => 16,
              'group_id' => 2,
              'tag_name' => '友達と一緒',
          ],
          [
              'id' => 17,
              'group_id' => 2,
              'tag_name' => '一人ぶらりと',
          ],
          [
              'id' => 18,
              'group_id' => 3,
              'tag_name' => '温泉',
          ],
          [
              'id' => 19,
              'group_id' => 3,
              'tag_name' => 'グルメ・食べ歩き',
          ],
          [
              'id' => 20,
              'group_id' => 3,
              'tag_name' => 'ショッピング',
          ],
          [
              'id' => 21,
              'group_id' => 3,
              'tag_name' => '海',
          ],
          [
              'id' => 22,
              'group_id' => 3,
              'tag_name' => '山・高原',
          ],
          [
              'id' => 23,
              'group_id' => 3,
              'tag_name' => '川・湖',
          ],
          [
              'id' => 24,
              'group_id' => 3,
              'tag_name' => '寺社仏閣',
          ],
          [
              'id' => 25,
              'group_id' => 3,
              'tag_name' => '街中',
          ],
          [
              'id' => 26,
              'group_id' => 3,
              'tag_name' => '駅近',
          ],
          [
              'id' => 27,
              'group_id' => 4,
              'tag_name' => '車',
          ],
          [
              'id' => 28,
              'group_id' => 4,
              'tag_name' => 'バイク',
          ],
          [
              'id' => 29,
              'group_id' => 4,
              'tag_name' => '電車・バス',
          ],
          [
              'id' => 30,
              'group_id' => 4,
              'tag_name' => '自転車・レンタサイクル',
          ],
          [
              'id' => 31,
              'group_id' => 2,
              'tag_name' => '屋内',
          ],
          [
              'id' => 32,
              'group_id' => 2,
              'tag_name' => '絶景',
          ],
          [
              'id' => 33,
              'group_id' => 2,
              'tag_name' => '夜景',
          ],
          [
              'id' => 34,
              'group_id' => 3,
              'tag_name' => '自然',
          ],
          [
              'id' => 35,
              'group_id' => 3,
              'tag_name' => 'レジャー・アウトドア',
          ],
          [
              'id' => 36,
              'group_id' => 4,
              'tag_name' => '徒歩',
          ],
      ];
 
      foreach($tags as $tag){
          DB::table('tags')->insert($tag);
      }
    }
}
