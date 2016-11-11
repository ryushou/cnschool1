<?php

class Controller_Report_Balance extends Controller {

	public function before() {
		parent::before();
	}

	public function action_index() {
		$deposit_order_id = Input::get('id');
		$deposit_jnl = Model_Deposit_Jnl::select_primary_admin($deposit_order_id);
		if(!$deposit_jnl || $deposit_jnl->reason != Config::get('constant.balance_adjust.reason')) {
			Response::redirect('base/timeout');
		}
		if(!Auth::has_access('balance.report')) {
			$user_id = Utility::get_user_id();
			if($deposit_jnl->user_id != $user_id) {
				Response::redirect('base/timeout');
			}
		}

		$before_deposit_jnl = Model_Deposit_Jnl::select_primary_admin_before($deposit_order_id, $deposit_jnl->user_id);
		$user = Model_Users::select_primary($deposit_jnl->user_id);
		$profile_fields = @unserialize($user->profile_fields);

		define('FONT', 'kozminproregular');

		Package::load('pdf');
        $pdf = \Pdf::factory()->init('L', 'mm', 'A5', true, 'UTF-8', false);

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

		$pdf->setSourceFile(Config::get('constant.pdf_template_dir') . 'balance.pdf');

	    //--

		// 新規ページ作成
		$pdf->AddPage();
	    $pdf->useTemplate($pdf->importPage(1));

	    // -- 左側
	    $base_left   = 21;
	    $pdf->SetFont(FONT, '', '26');

	    // 名前
        $pdf->SetXY($base_left, 31);
        $pdf->Cell(50, 6, $user->name, '', 0, 'L');

        // 合計金額
		$pdf->SetXY(58, 59);
        $pdf->Cell(50, 6, number_format($deposit_jnl->amount), '', 0, 'R');

        $pdf->SetFont(FONT, '', '15');

        // 調整日（Before）
        if($before_deposit_jnl) {
	        $date = new DateTime($before_deposit_jnl->created_at);
	        $pdf->SetXY(134, 28);
	        $pdf->Cell(50, 6, $date->format('Y年m月d日～'), '', 0, 'L');
        }
        // 調整日（After）
        $date = new DateTime($deposit_jnl->created_at);
        $pdf->SetXY(142, 35);
        $pdf->Cell(50, 6, $date->format('Y年m月d日まで'), '', 0, 'R');

		$pdf->Output('balance-' . $deposit_jnl->id . '-' . date("YmdHis") . '.pdf', 'I');
	}
}
