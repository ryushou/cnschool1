<?php

class Controller_Report_Bill extends Controller {

	const FONT = 'kozminproregular';
	const FONT_SIZE = '10.5';

	const BILL_TEMPLATE = 'bill.pdf';
	const BILL_ADJUST_TEMPLATE = 'bill_adjust.pdf';

	public function before() {
		parent::before();
		Package::load('pdf');
	}

	private function create_pdf($template_name) {
		
		ob_start();
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
		$pdf->SetFont(self::FONT, '', self::FONT_SIZE);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); // 固定長フォント設定

		// 自動改ページ
	    $pdf->SetAutoPageBreak(false);
	    $pdf->setSourceFile(Config::get('constant.pdf_template_dir') . $template_name);

	    return $pdf;
	}

	public function action_index() {
		$order_id = Input::get('id');
		$order = Model_Order_Jnl::select_primary_admin($order_id);
		if(!$order) {
			Response::redirect('base/timeout');
		}
		if(!Auth::has_access('bill.report')) {
			$user_id = Utility::get_user_id();
			if($order->user_id != $user_id) {
				Response::redirect('base/timeout');
			}
		}

		// order_jnlをorder_bill_jnlで置き換える
		$order = Model_Order_Bill_Jnl::select_primary_admin($order->id);
		if(!$order) {
			Response::redirect('base/timeout');
		}
		$user = Model_Users::select_primary($order->user_id);

	    //--
		$pdf = $this->create_pdf(self::BILL_TEMPLATE);

		// 新規ページ作成
		$pdf->AddPage();
	    $pdf->useTemplate($pdf->importPage(1));

	    // ヘッダ表示

	    // お客様名
	    $pdf->SetXY(21.2, 35);
        $pdf->Cell(50, 6, $user->name . ' 様', '', 0, 'L');

        // お客様番号
	    $pdf->SetXY(42, 98.2);
        $pdf->Cell(50, 6, $order->user_id, '', 0, 'L');

        // 注文番号
	    $pdf->SetXY(42, 107);
        $pdf->Cell(50, 6, $order->id, '', 0, 'L');

        // 請求書番号（注文番号）
	    $pdf->SetXY(167, 29);
        $pdf->Cell(25, 6, sprintf("No: %05d", $order->id), '', 0, 'R');

        // 発行年月日（現在日付）
	    $date = new DateTime($order->created_at);
	    $pdf->SetXY(167, 35);
        $pdf->Cell(25, 6, $date->format('Y年m月d日'), '', 0, 'R');

        // 為替レート
	    $pdf->SetXY(66.5, 105);
        $pdf->Cell(25, 6, $order->cny_jpy_rate, '', 0, 'L');

        // ご利用金額（円）
        $sum_expense = $order->sum_price - $order->sum_tax;

        // ご利用金額（元）
        $sum_expense_cny = round($sum_expense / $order->cny_jpy_rate, 3);

        // 消費税（元）
        $sum_tax_cny = round($order->sum_tax / $order->cny_jpy_rate, 3);

        // ご請求金額（元）
        $sum_price_cny = round($order->sum_price / $order->cny_jpy_rate, 3);


        // ご利用金額（円）
	    $pdf->SetXY(113, 105);
        $pdf->Cell(25, 6, number_format($sum_expense), '', 0, 'R');

        // 消費税（円）
	    $pdf->SetXY(134, 105);
        $pdf->Cell(25, 6, number_format($order->sum_tax), '', 0, 'R');

        // ご請求金額（円）
	    $pdf->SetXY(163, 105);
        $pdf->Cell(25, 6, number_format($order->sum_price), '', 0, 'R');

        // --

//        // ご利用金額（元）
//	    $pdf->SetXY(113, 114);
//        $pdf->Cell(25, 6, number_format($sum_expense_cny, 3), '', 0, 'R');
//
//        // 消費税（元）
//	    $pdf->SetXY(134, 114);
//        $pdf->Cell(25, 6, number_format($sum_tax_cny, 3), '', 0, 'R');
//
//        // ご請求金額（元）
//	    $pdf->SetXY(163, 114);
//        $pdf->Cell(25, 6, number_format($sum_price_cny, 3), '', 0, 'R');

        // --

		// ページ番号
		$pdf->SetXY(167, 275);
        $pdf->Cell(25, 6, $pdf->getPage() . ' / ' . $pdf->getNumPages(), '', 0, 'R');

		$details = array(
			array(
				'product_name' => '商品代金 (立替え)',
				'price' => number_format($order->product_price),
			),
			array(
				'product_name' => '代行手数料',
				'price' => number_format($order->commission),
			),
			array(
				'product_name' => '中国国内送料（概算）',
				'price' => number_format($order->national_delivery_fee),
			),
			array(
				'product_name' => '国際送料（概算）',
				'price' => number_format($order->international_delivery_fee),
			),
		);

		if($order->sum_send_directly_price > 0) {
			$details[] = array (
				'product_name' => '直送金額',
				'price' => number_format($order->sum_send_directly_price),
			);
		}

		if($order->option_price > 0) {
			$details[] = array (
				'product_name' => 'オプション金額',
				'price' => number_format($order->option_price),
			);
		}
		
		if($order->plana_planb_fee > 0) {
			$details[] = array (
				'product_name' => 'A/Bプラン',
				'price' => number_format($order->plana_planb_fee),
			);
		}

		if($order->payer_commission > 0) {
			if($order->payer_name!='PAYPAL') {			
				// 振込手数料 = ご利用金額 - 商品代金 - 代行手数料 - 国内送料 - 国際送料 - 消費税 - 直送金額 - オプション金額
				$payer_commission = $sum_expense
										- $order->product_price
										- $order->commission
										- $order->national_delivery_fee
										- $order->international_delivery_fee
										- $order->plana_planb_fee
										- $order->sum_send_directly_price
										- $order->option_price;
				if($payer_commission > 0) {
					$details[] = array (
						'product_name' => '振込手数料 (' . $order->payer_name . ')',
						'price' => number_format($payer_commission),
					);
				}
			}
		}

		// カラム幅 180
		$column_width = array(11, 57, 29, 29, 36);

		// テーブルコンテンツ部分
		foreach($details as $idx => $detail) {
			$pdf->SetXY(26, 139 + $idx * 11);

			$widx = 0;
			$pdf->Cell($column_width[$widx++], 6, $idx+1, '', 0, 'L');
			$pdf->Cell($column_width[$widx++], 6, $detail['product_name'], '', 0, 'L');
            $pdf->Cell($column_width[$widx++], 6, 1, '', 0, 'R');
            $pdf->Cell($column_width[$widx++], 6, $detail['price'], '', 0, 'R');
            $pdf->Cell($column_width[$widx++], 6, $detail['price'], '', 0, 'R');
		}
		$pdf->Output('bill-' . $order->user_id . '-' . $order->id . '-' . date("YmdHis") . '.pdf', 'I');
	}

	public function action_adjust() {
		$order_id = Input::get('id');
		$order = Model_Order_Jnl::select_primary_admin($order_id);
		if(!$order) {
			Response::redirect('base/timeout');
		}
		if(!Auth::has_access('bill.report')) {
			$user_id = Utility::get_user_id();
			if($order->user_id != $user_id) {
				Response::redirect('base/timeout');
			}
		}
		if($order->order_status != Config::get('constant.order_status.kbn.finish')) {
			Response::redirect('base/timeout');
		}

		$order_bill = Model_Order_Bill_Jnl::select_primary_admin($order->id);
		if(!$order_bill) {
			Response::redirect('base/timeout');
		}
		$user = Model_Users::select_primary($order->user_id);

		//--
		$pdf = $this->create_pdf(self::BILL_ADJUST_TEMPLATE);

		// 新規ページ作成
		$pdf->AddPage();
	    $pdf->useTemplate($pdf->importPage(1));

	    // ヘッダ表示

	    // お客様名
	    $pdf->SetXY(21.2, 35);
        $pdf->Cell(50, 6, $user->name . ' 様', '', 0, 'L');

        // お客様番号
	    $pdf->SetXY(42, 51.4);
        $pdf->Cell(50, 6, $order->user_id, '', 0, 'L');

        // 注文番号
	    $pdf->SetXY(42, 57.8);
        $pdf->Cell(50, 6, $order->id, '', 0, 'L');

        // 請求書番号（注文番号）
	    $pdf->SetXY(167, 29);
        $pdf->Cell(25, 6, sprintf("No: %05d", $order->id), '', 0, 'R');

        // 発行年月日（現在日付）
        $date = new DateTime($order->updated_at);
	    $pdf->SetXY(167, 35);
        $pdf->Cell(25, 6, $date->format('Y年m月d日'), '', 0, 'R');

        // 為替レート
	    $pdf->SetXY(25, 110);
        $pdf->Cell(25, 6, $order->cny_jpy_rate, '', 0, 'L');

        // ご請求金額（円）
	    $pdf->SetXY(64.5, 110);
        $pdf->Cell(25, 6, number_format($order_bill->sum_price), '', 0, 'R');

        // ご請求金額（元）
        //删除
        //$bill_price_cny = round($order_bill->sum_price / $order->cny_jpy_rate, 3);
	    //$pdf->SetXY(84.5, 114);
        //$pdf->Cell(25, 6, number_format($bill_price_cny, 3), '', 0, 'R');

        // --

        // ご利用金額（円）
        $sum_expense = $order->sum_price - $order->sum_tax;

        // ご精算金額（円）
        $sum_adjusts = $order_bill->sum_price - $order->sum_price;

        // ご利用金額（元）
        $sum_expense_cny = round($sum_expense / $order->cny_jpy_rate, 3);

        // 消費税（元）
        $sum_tax_cny = round($order->sum_tax / $order->cny_jpy_rate, 3);

        // ご請求金額（元）
        $sum_adjusts_cny = round($sum_adjusts / $order->cny_jpy_rate, 3);

         //デポジット時消費税（円）
	     $pdf->SetXY(90, 110);
         $pdf->Cell(25, 6, number_format($order->sum_tax), '', 0, 'R');
         
         //消費税（円）
	     $pdf->SetXY(136, 110);
         $pdf->Cell(25, 6, number_format($order->sum_tax), '', 0, 'R');
         
        // ご利用金額（円）
	    $pdf->SetXY(120.5, 110);
        $pdf->Cell(25, 6, number_format($sum_expense), '', 0, 'R');         

        // ご精算金額（円）
	    $pdf->SetXY(163, 110);
        $pdf->Cell(25, 6, number_format($sum_adjusts), '', 0, 'R');

        // --

        // ご利用金額（元）
	   // $pdf->SetXY(113, 114);
       //$pdf->Cell(25, 6, number_format($sum_expense_cny, 3), '', 0, 'R');

        // 消費税（元）
	    //$pdf->SetXY(134, 114);
        //$pdf->Cell(25, 6, number_format($sum_tax_cny, 3), '', 0, 'R');

        // ご精算金額（元）
	    //$pdf->SetXY(163, 114);
        //$pdf->Cell(25, 6, number_format($sum_adjusts_cny, 3), '', 0, 'R');

        // --

		// ページ番号
		$pdf->SetXY(167, 275);
      $pdf->Cell(25, 6, $pdf->getPage() . ' / ' . $pdf->getNumPages(), '', 0, 'R');

		$details = array(
			array(
				'product_name' => '商品代金 (立替え)',
				'price' => number_format($order->product_price),
			),
			array(
				'product_name' => '代行手数料',
				'price' => number_format($order->commission),
			),
			array(
				'product_name' => '国内送料 (中国内)',
				'price' => number_format($order->national_delivery_fee),
			),
			array(
				'product_name' => '国際送料',
				'price' => number_format($order->international_delivery_fee),
			),
		);

		if($order->sum_send_directly_price > 0) {
			$details[] = array (
				'product_name' => '直送金額',
				'price' => number_format($order->sum_send_directly_price),
			);
		}

		if($order->option_price > 0) {
			$details[] = array (
				'product_name' => 'オプション金額',
				'price' => number_format($order->option_price),
			);
		}
		
		if($order->plana_planb_fee > 0) {
			$details[] = array (
				'product_name' => 'A/Bプラン',
				'price' => number_format($order->plana_planb_fee),
			);
		}

		if($order->payer_commission > 0) {			
			if($order->payer_name!='PAYPAL') {					
				// 振込手数料 = ご利用金額 - 商品代金 - 代行手数料 - 国内送料 - 国際送料 - 消費税 - 直送金額 - オプション金額
				$payer_commission = $sum_expense
										- $order->product_price
										- $order->commission
										- $order->national_delivery_fee
										- $order->international_delivery_fee
										- $order->plana_planb_fee
										- $order->sum_send_directly_price
										- $order->option_price;
				
				
				$details[] = array (
					'product_name' => '振込手数料 (' . $order->payer_name . ')',
					'price' => number_format($payer_commission),
				);
			}
		}

		// カラム幅 180
		$column_width = array(11, 57, 29, 29, 36);

		// テーブルコンテンツ部分
		foreach($details as $idx => $detail) {
			$pdf->SetXY(26, 139 + $idx * 11);

			$widx = 0;
			$pdf->Cell($column_width[$widx++], 6, $idx+1, '', 0, 'L');
			$pdf->Cell($column_width[$widx++], 6, $detail['product_name'], '', 0, 'L');
            $pdf->Cell($column_width[$widx++], 6, 1, '', 0, 'R');
            $pdf->Cell($column_width[$widx++], 6, $detail['price'], '', 0, 'R');
            $pdf->Cell($column_width[$widx++], 6, $detail['price'], '', 0, 'R');
		}
		$pdf->Output('bill-adjust-' . $order->user_id . '-' . $order->id . '-' . date("YmdHis") . '.pdf', 'I');
	}
}
