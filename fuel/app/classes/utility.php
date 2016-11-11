<?php

class Utility {

    public static function get_query_profile_key() {
        return Config::get('constant.query_profile_key') . '_' . Utility::get_user_id();
    }

    public static function log_error($message_id, $screen_name = '', $value1 = '', $value2 = '', $value3 = '') {
        return Utility::log_save($message_id, 'error', $screen_name, $value1, $value2, $value3);
    }

    public static function log_info($message_id, $screen_name = '', $value1 = '', $value2 = '', $value3 = '') {
        return Utility::log_save($message_id, 'info', $screen_name, $value1, $value2, $value3);
    }

    private static function log_save($message_id, $log_level, $screen_name, $value1, $value2, $value3) {
        $user_id = Utility::get_user_id();
        Model_User_Logs::insert_user_logs($user_id, $screen_name, $log_level, $message_id, $value1, $value2, $value3);
    }

    public static function log_access($user_id) {
        $ip      = Input::ip();
        $uri     = Input::uri();
        $host    = gethostbyaddr($ip);
        $input   = Input::all();

        $request    = '';
        $now_length = 0;
        foreach($input as $key => $val) {
            if($val == '' || $key == 'fuel_csrf_token') {
                continue;
            }
            $append = '';
            if($now_length > 0) {
                $append = '&';
            }
            if(is_string($key) && is_string($val)) {
                $append .= $key . '=' . $val;
            }
            $append_length = mb_strlen($append);
            if($now_length + $append_length > 255) {
                break;
            }
            $request .= $append;
            $now_length += $append_length;
        }
        Model_Access_Logs::insert_access_logs($user_id, $uri, $request, $ip, $host);
    }

    public static function get_mail_template($name) {
        return file_get_contents(APPPATH.'tmp'.DS.'mail'.DS.$name);
    }

    public static function is_empty($value) {
        return $value == '';
    }

    public static function is_empty_date($value) {
        return $value == '' || $value == '0000-00-00 00:00:00' || $value == '0000-00-00';
    }

    public static function get_datetime_now() {
        return date('Y-m-d H:i:s');
    }

    public static function get_form_date_value($value) {
        if(Utility::is_empty_date($value)) {
            return '';
        } else {
            return $value;
        }
    }

    public static function query_likes($select, $field, $likes) {
        $likes = Utility::mb_str_replace("　", " ", $likes);
        foreach(explode(" ", $likes) as $like) {
            if($like != '') {
                $select = $select->and_where($field, 'LIKE', '%' . $like . '%');
            }
        }
    }

    public static function or_query_likes($select, $field, $likes) {
        $likes = Utility::mb_str_replace("　", " ", $likes);
        foreach(explode(" ", $likes) as $like) {
            if($like != '') {
                $select = $select->or_where($field, 'LIKE', '%' . $like . '%');
            }
        }
    }

    public static function query_not_likes($select, $field, $likes) {
        $likes = Utility::mb_str_replace("　", " ", $likes);
        foreach(explode(" ", $likes) as $like) {
            if($like != '') {
                $select = $select->and_where($field, 'NOT LIKE', '%' . $like . '%');
            }
        }
    }

    public static function query_between($select, $field, $from, $to) {
        if(!Utility::is_empty($from)) {
            if(!Utility::is_empty($to)) {
                $select = $select->and_where($field, 'between', array($from, $to));
            } else {
                $select = $select->and_where($field, '>=', $from);
            }
        } else {
            if(!Utility::is_empty($to)) {
                $select = $select->and_where($field, '<=', $to);
            }
        }
    }

    public static function query_select_between($field, $from, $to) {
        if(!Utility::is_empty($from)) {
            if(!Utility::is_empty($to)) {
                $select = ' AND ' . $field . ' BETWEEN "' . $from . '" AND "' . $to . '" ';
            } else {
                $select = ' AND ' . $field . ' >= "' . $from . '" ';
            }
        } else {
            if(!Utility::is_empty($to)) {
                $select = ' AND ' . $field . ' <= "' . $to . '" ';
            }
        }
        return $select;
    }

    public static function get_date_value($val) {
        if(!Utility::is_empty($val)) {
            return date('Y-m-d', strtotime($val));
        } else {
            return ''; 
        }
    }

    public static function get_date_time_value($val) {
        if(!Utility::is_empty($val)) {
            return date('Y-m-d H:i:s', strtotime($val));
        } else {
            return ''; 
        }
    }

    public static function get_human_timing($date_time_string) {
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        $date_time = DateTime::createFromFormat('Y-m-d H:i:s', $date_time_string);
        $timestamp = Date::time()->get_timestamp() - $date_time->getTimestamp();
        foreach ($tokens as $unit => $text) {
            if ($timestamp < $unit) continue;
            $numberOfUnits = floor($timestamp / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    }

    public static function status_query($select, $field, $status, $status_range) {
        if(!Utility::is_empty($status)) {
            if($status_range == 'before') {
                Utility::query_between($select, $field, '', DB::expr($status));
            } else if($status_range == 'after') {
                Utility::query_between($select, $field, DB::expr($status), '');
            } else {
                $select = $select->and_where($field, '=', DB::expr($status));
            }
        }
    }

    public static function get_user_id() {
        return Auth::get_user_id()[1];
    }

    public static function get_order_sheet_detail_count($user_id) {
        $user = Model_Users::select_primary($user_id);
        if($user->order_detail_count != 0) {
            return $user->order_detail_count;
        } else {
            if($user->member_rank == Config::get('constant.member_rank.kbn.normal')) {
                return Config::get('constant.order_detail_count_normal');
            } else {
                return Config::get('constant.order_detail_count');
            }
        }
    }

    public static function get_unit_international_delivery_fee_rate($amount) {
        if($amount >= Config::get('constant.unit_international_delivery_rank_a_min') 
            && $amount < Config::get('constant.unit_international_delivery_rank_b_min')) {
            return Config::get('constant.unit_international_delivery_rank_a_fee');
        } else if($amount >= Config::get('constant.unit_international_delivery_rank_b_min') 
            && $amount < Config::get('constant.unit_international_delivery_rank_c_min')) {
            return Config::get('constant.unit_international_delivery_rank_b_fee');
        } else if($amount >= Config::get('constant.unit_international_delivery_rank_c_min')) {
            return Config::get('constant.unit_international_delivery_rank_c_fee');
        } else {
            return 0;
        }
    }

    public static function add_detail_validation($validation, $property, $idx, $field, $name) {
        return $validation->add($property . '.' . $idx . '[' . $field . ']', $idx+1 . '行目 => ' . $name);
    }

    public static function get_receiver_select() {
        $receivers = Model_Receivers::get_receiver_lists(Utility::get_user_id());
        $details = array('' => '');
        foreach ($receivers as $receiver) {
            $details[$receiver->id] = $receiver->receiver;
        }
        return $details;
    }

    public static function get_payers_label($entry) {
        $label = $entry->payer_name;
        if($entry->payer_commission > 0) {
            $label .= ' ／手数料' . $entry->payer_commission . '%';
        }
        return $label;
    }

    public static function get_payer_select() {
        $entries = Model_Payers::get_payer_lists();
        $details = array('' => '');
        foreach ($entries as $entry) {
            $details[$entry->id] = Utility::get_payers_label($entry);
        }
        return $details;
    }

    public static function get_deposit_input_payer_select() {
        $entries = Config::get('constant.deposit_input_payers');
        $details = Utility::get_payer_select();
        foreach ($entries as $key => $payer_name) {
            $details[$key] = $payer_name;
        }
        return $details;
    }

    public static function get_deliver_select($kbn) {
        $entries = Model_Deliveries::get_deliver_lists($kbn);
        $details = array('' => '');
        foreach ($entries as $entry) {
            $details[$entry->name] = $entry->name;
        }
        return $details;
    }

    public static function get_constant_get2($kbn1, $kbn2) {
        return Config::get($kbn1 . '.' . $kbn2);
    }

    public static function get_constant_name2($kbn1, $kbn2, $key = '') {
        return Utility::get_constant_name($kbn1 . '.' . $kbn2, $key);
    }

    public static function get_constant_name($kbn, $key = '') {
        $constant = Config::get('constant.' . $kbn . '.name');
        if(Utility::is_empty($key)) {
            return $constant;
        } else {
            if($constant && array_key_exists($key, $constant)) {
                return $constant[$key];
            } else {
                return '';
            }
        }
    }

    public static function get_paging_config($total_items) {
        $config = array(
            'pagination_url' => '',
            'per_page'       => 10,
            'total_items'    => $total_items,
            'uri_segment'    => 'page',
            'num_links'      => 10,
            'show_first'     => true,
            'show_last'      => true,
        );
        return $config;
    }

    public static function register_shutdown_function($user_id) {
        list($max) = sscanf(ini_get('memory_limit'), '%dM');  // 512M のように M で指定されている前提なのでアレでごめんなさい
        $peak = memory_get_peak_usage(true) / 1024 / 1024;
        $used = ((int) $max !== 0)? round((int) $peak / (int) $max * 100, 2): '--';
        if ($used > 10) {
            $message = sprintf("id:%s Memory peak usage warning: %s %% used. (max: %sM, now: %sM)", $user_id, $used, $max, $peak);
            Log::warning($message);
        }
    }

    /**
     * マルチバイト対応 str_replace()
     * 
     * @param   mixed   $search     検索文字列（またはその配列）
     * @param   mixed   $replace    置換文字列（またはその配列）
     * @param   mixed   $subject    対象文字列（またはその配列）
     * @param   string  $encoding   文字列のエンコーディング(省略: 内部エンコーディング)
     *
     * @return  mixed   subject 内の search を replace で置き換えた文字列
     *
     * この関数の $search, $replace, $subject は配列に対応していますが、
     * $search, $replace が配列の場合の挙動が PHP 標準の str_replace() と異なります。
     */
    public static function mb_str_replace($search, $replace, $subject, $encoding = 'auto') {
        if(!is_array($search)) {
            $search = array($search);
        }
        if(!is_array($replace)) {
            $replace = array($replace);
        }
        if(strtolower($encoding) === 'auto') {
            $encoding = mb_internal_encoding();
        }
 
        // $subject が複数ならば各要素に繰り返し適用する
        if(is_array($subject) || $subject instanceof Traversable) {
            $result = array();
            foreach($subject as $key => $val) {
                $result[$key] = mb_str_replace($search, $replace, $val, $encoding);
            }
            return $result;
        }
 
        $currentpos = 0;    // 現在の検索開始位置
        while(true) {
            // $currentpos 以降で $search のいずれかが現れる位置を検索する
            $index = -1;    // 見つけた文字列（最も前にあるもの）の $search の index
            $minpos = -1;   // 見つけた文字列（最も前にあるもの）の位置
            foreach($search as $key => $find) {
                if($find == '') {
                    continue;
                }
                $findpos = mb_strpos($subject, $find, $currentpos, $encoding);
                if($findpos !== false) {
                    if($minpos < 0 || $findpos < $minpos) {
                        $minpos = $findpos;
                        $index = $key;
                    }
                }
            }
 
            // $search のいずれも見つからなければ終了
            if($minpos < 0) {
                break;
            }
 
            // 置換実行
            $r = array_key_exists($index, $replace) ? $replace[$index] : '';
            $subject =
                mb_substr($subject, 0, $minpos, $encoding) .    // 置換開始位置より前
                $r .                                            // 置換後文字列
                mb_substr(                                      // 置換終了位置より後ろ
                    $subject,
                    $minpos + mb_strlen($search[$index], $encoding),
                    mb_strlen($subject, $encoding),
                    $encoding);
 
            // 「現在位置」を $r の直後に設定
            $currentpos = $minpos + mb_strlen($r, $encoding);
        }
        return $subject;
    }
  }
?>