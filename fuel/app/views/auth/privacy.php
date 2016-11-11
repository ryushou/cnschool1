<?php Asset::add_path('assets/plugins/', 'js');  ?>

<!-- CSS Global Compulsory -->
<?= Asset::css('theme/top.css');?>

<!-- CSS Theme -->    
<?= Asset::css('theme/themes/orange.css');?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
    <div class="container">
        <h1 class="pull-left">プライバシーポリシー</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?= Uri::create("/") ?>">トップページ</a></li>
            <li class="active">プライバシーポリシー</li>
        </ul>
    </div>
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!--=== Content Part ===-->
<div class="container content">     
    <div class="row-fluid privacy">
	    <div class="panel panel-dark">
            <div class="panel-heading">
                <i class="fa fa-check-square-o"></i>&nbsp;本サービスのプライバシーポリシー
            </div>
            <div class="panel-body">
            	<p>
            		弊社（環日本海）は、顧客殿の個人情報保護を最優先課題として捉え、これを尊重し適切な保護に努めます。<br/>
					よって、下記プライバシーポリシーを設定し、業務遂行を実施します。<br/>
            	</p>

		        <p>第１条（プライバシーポリシーについて）</p>
		        <ol>
		            <li>顧客殿よりご提供を受けた個人情報、アンケート等の内容については、適切な管理のもとに保管し、その利用は弊社業務にのみに利用させて頂きます。よって、法令要求あるいは、顧客殿の許可を頂いた場合を除き、第三者に提供することはいたしません。</li>
		        </ol>

		        <p>第２条（顧客情報の利用について）</p>
		        <ol>
		            <li>弊社は顧客殿から頂いた情報は、商品の発送、顧客殿の確認、ご連絡等、弊社業務に限定し利用させて頂きます。</li>
		        </ol>

		        <p>第３条（個人情報の開示について）</p>
		        <ol>
		            <li>原則、顧客殿の事前同意なしに顧客殿の個人情報を開示することはありません。但し、法令により要求を受けた場合、あるいは弊社の権利や財産を保護する必要が生じた場合は、必要最低限の情報を使用させて頂くことがあります。</li>
		        </ol>

		        <p>第４条（ご提供頂いた情報の取り扱い体制について）</p>
		        <ol>
		            <li>顧客殿から頂いた各種情報については、弊社で責任をもって管理させて頂きます。</li>
		        </ol>

		        <p>第５条（免責事項）</p>
		        <ol>
		            <li>弊社を利用される顧客殿は、上記プライバシーポリシーに同意して頂いたものと判断させて頂きます。</li>
		        </ol>
	        </div>
        </div>
    </div><!--/row-fluid-->        
</div><!--/container-->     
<!--=== End Content Part ===-->

<!-- JS Implementing Plugins -->
<?= Asset::js('back-to-top.js');?>