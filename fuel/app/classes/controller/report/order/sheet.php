<?php

class Controller_Report_Order_Sheet extends Controller {

	public function before() {
		parent::before();
		if (!Auth::has_access('order.list')) {
			Response::redirect('base/timeout');
		}
	}

	private function get_convert_eol($str, $to = "\n") {
		return preg_replace("/\r\n|\r|\n/", $to, $str);
	}

	private function get_font_size_from_str_length($str, $magnification = 1.0) {
		
		 ob_start();
		$length = strlen($str);
		if($length >= 420 * $magnification) {
			return '5';
		} else if($length >= 260 * $magnification) {
			return '6';
		} else if($length >= 190 * $magnification) {
			return '7';
		} else if($length >= 120 * $magnification) {
			return '8';
		} else if($length >= 100 * $magnification) {
			return '9';
		} else {
			return '10';
		}
	}

	public function action_index() {
		$order_id = Input::get('id');
		$order_jnl = Model_Order_Jnl::select_primary_admin($order_id);
		
		if(!$order_jnl) {
			Response::redirect('base/timeout');
		}
		$order_detail_list = Model_Order_Detail::get_order_list_admin($order_jnl->id);
		$user = Model_Users::select_primary($order_jnl->user_id);
		$commission = Model_Commissions::select_primary($user->member_rank);
       

		
		
		define('FONT', 'kozminproregular');

		Package::load('pdf');
        $pdf = \Pdf::factory()->init('L', 'mm', 'A4', true, 'UTF-8', false);

		// ヘッダー&フッター
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// マージン設定
		$pdf->SetCellPadding(0);
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->setCellHeightRatio(1.2);

		// フォント設定
		$pdf->SetTextColor(10, 10, 10);
		$pdf->SetFont(FONT, '', '10');
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // 固定長フォント設定

		// 自動改ページ
	    $pdf->SetAutoPageBreak(false);

	    // テンプレートを取得
		$pdf->setSourceFile(Config::get('constant.pdf_template_dir') . 'order_sheet.pdf');

	    // 明細数
	    $next_page_detail_no = 0;
	    $detail_count = 0;

	    // 出力できない画像のバイト数
	    $not_print_image_size = 65535;

		// テーブルコンテンツ部分
		foreach($order_detail_list as $detail) {
			if($detail->detail_no == $next_page_detail_no) {
				// 新規ページ作成
				$pdf->AddPage();
				if($pdf->getPage() == 1) {
					$template_page = 1;
					$detail_count  = 6;
				} else {
					$template_page = 2;
					$detail_count  = 7;
				}
				$next_page_detail_no += $detail_count;
			    $pdf->useTemplate($pdf->importPage($template_page));

			    if($template_page == 1) {
				    $pdf->SetTextColor(255, 10, 10);
					$pdf->SetFont(FONT, '', '17');

					if($order_jnl->send_fba_flg == Config::get('constant.address_kind.kbn.fba') 
						|| $order_jnl->send_fba_flg == Config::get('constant.address_kind.kbn.fba_ship')) {
						$send_fba_flg = true;
					} else {
						$send_fba_flg = false;
					}

				    // 配送先オプション
					if($send_fba_flg && $order_jnl->order_kbn != Config::get('constant.order_kbn.kbn.oem')) {
						$delivery_option = Utility::get_constant_name2('delivery_option', $order_jnl->order_kbn, Config::get('constant.delivery_option.kbn.fba'));
					} else {
						$delivery_option = Utility::get_constant_name2('delivery_option', $order_jnl->order_kbn, Config::get('constant.delivery_option.kbn.standard'));
					}
					$pdf->SetXY(260, 11);
			        $pdf->Cell(25, 6, $delivery_option, '', 0, 'R');

				    // 特別検査項目
				    if($order_jnl->special_inspection_flg == Config::get('constant.special_inspection.kbn.yes')) {
						$pdf->SetXY(260, 18);
				        $pdf->Cell(25, 6, '特別検査項目', '', 0, 'R');
				    }

				    // フォントを戻す
				    $pdf->SetTextColor(10, 10, 10);
					$pdf->SetFont(FONT, '', '10');

				    // ヘッダ表示
				    $line_height = 5;

				    // ヘッダ左上
				    $base_height = 25.5;
                   
				    $pdf->SetXY(13, $base_height);
			        $pdf->Cell(50, 6, 'No: ' . $order_jnl->id, '', 0, 'L');
			        $base_height += $line_height;

				    $base_left   = 35;
				    $base_height = 25.5;

				    $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, Config::get('constant.server_identifier')  . ' - ' . $order_jnl->user_id, '', 0, 'L');
			        $base_height += $line_height;

				    $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, $user->name, '', 0, 'L');
			        $base_height += $line_height;

				    $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, $commission->name, '', 0, 'L');
			        $base_height += $line_height;

				    $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, '手数料: ' . $commission->commission . '%', '', 0, 'L');
			        $base_height += $line_height;

			        // -- 右側
			        $base_left   = 155;
			        $base_height = 25.5;

			        // 配送先宛名
			        $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, str_replace('-', '/', $order_jnl->send_name), '', 0, 'L');
			        $base_height += $line_height;

			        // 郵便番号 配送先１
			        $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, $order_jnl->send_zip1 . '-' . $order_jnl->send_zip2 . ' ' . $order_jnl->send_address1, '', 0, 'L');
			        $base_height += $line_height;

			        // 配送先２
			        if(!Utility::is_empty($order_jnl->send_address2)) {
				        $pdf->SetXY($base_left, $base_height);
				        $pdf->Cell(50, 6, $order_jnl->send_address2, '', 0, 'L');
				        $base_height += $line_height;
				    }

			        // 配送先電話番号
			        $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, $order_jnl->send_phone, '', 0, 'L');
			        $base_height += $line_height;

			        // 発行年月日（現在日付）
			        
			       $date = Model_Send_Jnl::find_delivery_date($order_id);
                   if($date[0]['mindate']=='0000-00-00'){
        	               unset($order_date);
                     }else{
        	         $order_date = new DateTime($date[0]['mindate']);
        	         		$pdf->SetXY(260, 25.5);
			        $pdf->Cell(25, 6, $order_date->format('Y年m月d日'), '', 0, 'R');
                    }

			    }
		        // -- フッタ
		        $pdf->SetFont(FONT, '', '11');

				// ページ番号
				$pdf->SetXY(130, 200);
		        $pdf->Cell(25, 6, $pdf->getPage(), '', 0, 'R');
			}
			$line_height = 22.5;
			if($pdf->getPage() == 1) {
				$detail_surplus = $detail->detail_no % 6;
				$detail_height_revision = 0;
			} else {
				$detail_surplus = ($detail->detail_no +1) % 7;
				$detail_height_revision = -24.3;
			}
			$line_Y = 57.5 + $detail_surplus * $line_height + $detail_height_revision;

			$detail_font_size = '9';

			// No
			$pdf->SetXY(13, $line_Y);
			$pdf->SetFont(FONT, '', $detail_font_size);
			$pdf->Cell(5, $line_height, $detail->detail_no+1, '', 0, 'C');

			// 写真1
			$image = Model_Images::select_primary($detail->image_id);
			if($image) {
				if(strlen($image->file_data) == $not_print_image_size) {
					$image->file_data = file_get_contents(Asset::get_file('noimage.png', 'img'));
				}
				$pdf->SetXY(20, $line_Y+0.5 );
				$pdf->Image('@' . $image->file_data, $pdf->GetX(), $pdf->GetY(), 20, 20, '', '', '', false, 300);
				
			}
			// 写真2
			$image = Model_Images::select_primary($detail->image_id2);
			if($image) {
				if(strlen($image->file_data) == $not_print_image_size) {
					$image->file_data = file_get_contents(Asset::get_file('noimage.png', 'img'));
				}
				$pdf->SetXY(43, $line_Y+0.5);
				$pdf->Image('@' . $image->file_data, $pdf->GetX(), $pdf->GetY(), 20, 20, '', '', '', false, 300);
			}

			// バリエーション
			$pdf->SetXY(66, $line_Y);
			$pdf->SetFont(FONT, '', $this->get_font_size_from_str_length($detail->valiation, 1.5));
			$pdf->MultiCell(57, $line_height, $this->get_convert_eol($detail->valiation, '／'), 0, 'L', false, 1, '', '', true, 0, false, true, $line_height, 'M');

			// 要望
			$pdf->SetXY(123.5, $line_Y);
			$pdf->SetFont(FONT, '', $this->get_font_size_from_str_length($detail->demand));
			$pdf->MultiCell(39, $line_height, $this->get_convert_eol($detail->demand, '／'), 0, 'L', false, 1, '', '', true, 0, false, true, $line_height, 'M');

			// 実数量
			$pdf->SetXY(171.5, $line_Y);
			$pdf->SetFont(FONT, '', $detail_font_size);
			$pdf->Cell(6, 10, number_format($detail->real_amount), '', 0, 'C');

			// SKU
			$pdf->SetXY(171.5, $line_Y-1);
			$pdf->SetFont(FONT, '', '8');
			$pdf->Cell(6, 32, $detail->sku, '', 0, 'C');
			

            //単価（円）
            //$pdf->SetXY(177, $line_Y);
            //$pdf->SetFont(FONT, '', '8');
            //$pdf->Cell(6, 10, $detail->japan_price, '', 0, 'C');

            //単価（元）
            //$pdf->SetXY(177, $line_Y);
            //$pdf->SetFont(FONT, '', '8');
            //$pdf->Cell(6, 32, $detail->china_price, '', 0, 'C');

			// 商品ステータス
			$cell_width = 9;
			$status_name = Utility::get_constant_name2('order_status', $order_jnl->order_kbn, $detail->detail_status);
			$length = mb_strlen($status_name, 'UTF-8');
			if($length == 5) {
				$status_name = mb_substr($status_name, 0, 2, 'UTF-8') . "\n" . mb_substr($status_name, 2, 3, 'UTF-8');
			} else if($length == 4) {
				$status_name = mb_substr($status_name, 0, 2, 'UTF-8') . "\n" . mb_substr($status_name, 2, 2, 'UTF-8');
			}
			$pdf->SetXY(187.5, $line_Y);
			$pdf->SetFont(FONT, '', 8);
			$pdf->MultiCell($cell_width, $line_height, $status_name, 0, 'C', false, 1, '', '', true, 0, false, true, $line_height, 'M');

			// 管理者メッセージ
			$pdf->SetXY(199, $line_Y);
			$pdf->SetFont(FONT, '', $this->get_font_size_from_str_length($detail->admin_message));
			$pdf->MultiCell(34, $line_height, $this->get_convert_eol($detail->admin_message, '／'), 0, 'L', false, 1, '', '', true, 0, false, true, $line_height, 'M');
		}
		$pdf->Output('order-sheet-' . $order_jnl->id . '-' . date("YmdHis") . '.pdf', 'I');
	}
}
