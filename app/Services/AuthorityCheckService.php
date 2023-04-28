<?php

namespace App\Services;

class AuthorityCheckService{
    
    // アクセスユーザーが投稿の投稿者かチェック
    public function is_owner($post){
        if($post->user_id !== \Auth::user()->id){
            return false;
        }else{
            return true;
        }
    }
    
    // 新規作成のスポットに関するフォームが不正でないかチェック
    public function is_legal_number_of_spots_and_array_keys_for_store($request){
        // スポットに関する各配列を配列($spot_items)に格納
        $spot_items = [
            $request->spot_names,
            $request->file('spot_images'),
            $request->spot_comments,
        ];
        
        // 比較用の配列を生成（[0~スポット数-1]の連続した数が格納された配列）
        $array_for_comparison = range(0, $request->number_of_spots-1);
        
        // スポットに関する各配列に対して、配列のキーが[0~スポット数-1]の連続した数か否かチェック
        foreach($spot_items as $item){
            // $itemのキーのみ抜き出し配列を生成
            $item_keys = array_keys($item);
            // 比較用の配列と、$item_keys配列と比較
            if($array_for_comparison === $item_keys){
                $results[] = true; //結果を格納
            }else{
                $results[] = false; //結果を格納
            }
        }
        
        // 各結果が全て一致、かつ中身がtrueであれば、trueをリターン
        if(count(array_unique($results)) === 1 && $results[0] === true){
            return true;
        }else{
            return false;
        };
    }
    
    // 編集フォームが不正でないかチェック
    public function is_legal_array_keys_for_edit($request, $post ,$spot_image_keys){
        // スポット名、コメントを配列($spot_items)に格納
        $spot_items = [
            $request->spot_names,
            $request->spot_comments,
        ];
        
        // 投稿のスポット数をカウント
        $number_of_spots = $post->spots->count();
        
        // 比較用の配列を生成（[0~スポット数-1]の連続した数が格納された配列）
        $array_for_comparison = range(0, $number_of_spots-1);
        
        // スポット名、コメントの各配列に対して、配列のキーが[0~スポット数-1]の連続した数か否かチェックし結果を格納
        foreach($spot_items as $item){
            // $itemのキーのみ抜き出し配列を生成
            $item_keys = array_keys($item);
            // 比較用の配列と、$item_keys配列と比較
            if($array_for_comparison === $item_keys){
                $results[] = true;
            }else{
                $results[] = false;
            }
        }
        
        // 変更する画像のキーが不正でないかチェックし結果を格納
        if(isset($spot_image_keys)){
            foreach($spot_image_keys as $key){
                if($key >= 0 && $key <= $number_of_spots-1 && gettype($key) === "integer"){
                    $results[] = true;
                }else{
                    $results[] = false;
                }
            }
        }else{
            $results[] = true;
        }
        
        // 各結果が全て一致、かつ中身がtrueであれば、trueをリターン
        if(count(array_unique($results)) === 1 && $results[0] === true){
            return true;
        }else{
            return false;
        };
    }
    
    // 不正なアクセスならば警告を表示
    public function if_cheater_indicate_warning($is_result){
        if($is_result !== true){
            session()->flash('warning', '不正なアクセスです');
        }
    }
    
    // 不正な操作ならば警告を表示
    public function if_illegal_indicate_warning($is_result){
        if($is_result !== true){
            session()->flash('warning', '不正な操作です');
        }
    }
    
}