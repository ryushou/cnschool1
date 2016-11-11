<?php

class Controller_Report_Invoice extends Controller {

	public function before() {
		parent::before();
	}

	public function action_index() {
		$send_id = Input::get('id');
		$send_jnl = Model_Send_Jnl::select_primary_admin($send_id);
		if(!$send_jnl) {
			Response::redirect('base/timeout');
		}
		if(!Auth::has_access('invoice.report')) {
			$user_id = Utility::get_user_id();
			if($send_jnl->user_id != $user_id) {
				Response::redirect('base/timeout');
			}
		}

		$order             = Model_Order_Jnl::select_primary($send_jnl->user_id, $send_jnl->order_id);
		$detail_ids        = Model_Send_Detail::get_order_detail_ids($send_jnl->id);
		$order_detail_list = Model_Order_Detail::select_primaries($send_jnl->order_id, $detail_ids);

		$send_details  = array();
		$order_details = array();
		foreach ($order_detail_list as $order_detail) {
			$send_detail = Model_Send_Detail::select_primary($send_jnl->id, $order_detail->id);
			if(!$send_detail) {
				Response::redirect('base/timeout');
			}
			$send_details[] = $send_detail;
			$order_details[] = $order_detail;
		}

		$user = Model_Users::select_primary($send_jnl->user_id);
		$profile_fields = @unserialize($user->profile_fields);
		$user_zip       = \Arr::get($profile_fields, 'zip', '');
		$user_address1  = \Arr::get($profile_fields, 'address1', '');
		$user_address2  = \Arr::get($profile_fields, 'address2', '');
		$user_tel       = \Arr::get($profile_fields, 'phone', '');

		define('FONT', 'kozminproregular');

		Package::load('pdf');
        $pdf = \Pdf::factory()->init('P', 'mm', 'A4', true, 'UTF-8', false);

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
		$pdf->SetFont(FONT, '', '11');
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // 固定長フォント設定

		// 自動改ページ
	    $pdf->SetAutoPageBreak(false);

		$pdf->setSourceFile(Config::get('constant.pdf_template_dir') . 'invoice.pdf');

	    //--

		// カラム幅 180
		$column_width = array(15, 67, 29, 29, 29);

		// テーブルコンテンツ部分
		foreach($send_details as $idx => $detail) {
			if($idx %10 == 0) {
				// 新規ページ作成
				$pdf->AddPage();
			    $pdf->useTemplate($pdf->importPage(1));

			    // ヘッダ表示
			    $line_height = 5;

			    // -- 左側
			    $base_left   = 25;

			    // 荷受人
			    $base_height = 80;

			    $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, $order->send_receiver, '', 0, 'L');
		        $base_height += $line_height;

			    $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, $order->send_name, '', 0, 'L');
		        $base_height += $line_height;

			    $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, '〒' . $order->send_zip1 . $order->send_zip2, '', 0, 'L');
		        $base_height += $line_height;

			    $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, $order->send_address1, '', 0, 'L');
		        $base_height += $line_height;

		        if(!Utility::is_empty($order->send_address2)) {
				    $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, $order->send_address2, '', 0, 'L');
			        $base_height += $line_height;
		        }
			    $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, 'TEL: ' . $order->send_phone, '', 0, 'L');
		        $base_height += $line_height;


		        // -- 右側
		        $base_left   = 115;
		        $line_height = 11;
		        $base_height = 39.5;

		        // 配送日付
		        $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, str_replace('-', '/', $send_jnl->delivery_date), '', 0, 'L');
		        $base_height += $line_height;

		        // 配送手段
		        $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, $send_jnl->delivery_name, '', 0, 'L');
		        $base_height += $line_height;

		        // 追跡番号
		        $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, $send_jnl->send_no, '', 0, 'L');
		        $base_height += $line_height;

		        // 注文番号
		        $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, $order->id, '', 0, 'L');
		        $base_height += $line_height;

		        // 箱数
		        $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, number_format($send_jnl->total_box), '', 0, 'L');
		        $base_height += $line_height;

		        $base_height += $line_height;

		        // 輸入者
		        $import_line_height = 4;
		        $pdf->SetFont(FONT, '', '9');

		        $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, $user->name, '', 0, 'L');
		        $base_height += $import_line_height;

			    $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, $user_zip . ' ' . $user_address1, '', 0, 'L');
		        $base_height += $import_line_height;

		        if(!Utility::is_empty($user_address2)) {
				    $pdf->SetXY($base_left, $base_height);
			        $pdf->Cell(50, 6, $user_address2, '', 0, 'L');
			        $base_height += $import_line_height;
			    }
			    $pdf->SetXY($base_left, $base_height);
		        $pdf->Cell(50, 6, 'TEL: ' . $user_tel, '', 0, 'L');
		        $base_height += $import_line_height;

		        $pdf->SetFont(FONT, '', '11');

		        // -- フッタ

		        // 合計金額
				$pdf->SetXY(167, 257);
		        $pdf->Cell(25, 6, number_format($send_jnl->total_price), '', 0, 'R');

				// ページ番号
				$pdf->SetXY(167, 273);
		        $pdf->Cell(25, 6, $pdf->getPage() . ' / ' . $pdf->getNumPages(), '', 0, 'R');
			}
			$pdf->SetXY(21, 135 + ($idx %10) * 10);

			$widx = 0;
			$pdf->Cell($column_width[$widx++], 6, $order_details[$idx]->detail_no+1, '', 0, 'L');
			$pdf->Cell($column_width[$widx++], 6, $detail->product_name, '', 0, 'L');
            $pdf->Cell($column_width[$widx++], 6, number_format($detail->amount), '', 0, 'R');
            $pdf->Cell($column_width[$widx++], 6, number_format($detail->unit_price), '', 0, 'R');
            $pdf->Cell($column_width[$widx++], 6, number_format($detail->product_price), '', 0, 'R');
		}
		$pdf->Output('invoice-' . $order->id . '-' . $send_jnl->id . '-' . date("YmdHis") . '.pdf', 'I');
	}
}
