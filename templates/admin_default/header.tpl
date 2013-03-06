<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
	<head>
		<title>{$site_title}</title>
		<base href="{$site_url}" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="{$template_path}general.css" type="text/css" />
		<script type="text/javascript" src="include_js/ajax.js"></script>
        <script type="text/javascript" src="include_js/admin.js"></script>
		<!--[if lt IE 7.]>
		<script defer type="text/javascript">
			var site_url = '{$site_url}';
		</script>
		<script defer type="text/javascript" src="include_js/pngfix.js"></script>
		<![endif]-->
			</head>
	<body id="admin_cont">
        <div class="top_header">
            <div style="position: relative; top:80px;"><img src="http://snowhall.com/logo/2/v2_logo.jpg" /></div>
		</div>
		<div class="middle_wrapper">
			<div class="clear_both"></div>

			<div class="right_menu_wrapper">
				<div class="clear_both"></div>
					<div class="menu_wrapper"><div class="menu_categ_wrapper"><div class="menu_categ_header"><a href="admin/">{"MAIN MENU"|t}</a></div></div>


<div class="menu_categ_wrapper">
  <div class="menu_categ_header"><img src="templates/admin_default/images/icons/ico0.gif" align="left">&nbsp;&nbsp;{"Users"|t}</div>
  <div class="menu_items_wrapper" id="menu_items_wrapper_1">
    <div class="menu_item_wrapper"><a href="admin/profiles.php" >{"Members"|t}</a></div>
    <div class="menu_item_wrapper"><a href="admin/payment_statistic.php" >{"Member payments"|t}</a></div>
  </div>
</div>
<div class="menu_categ_wrapper">
  <div class="menu_categ_header"><img src="templates/admin_default/images/icons/ico1.gif" align="left">&nbsp;&nbsp;{"Store Settings"|t}</div>
  <div class="menu_items_wrapper" id="menu_items_wrapper_1">
    <div class="menu_item_wrapper"><a href="admin/prop_seller.php" >{"Product Properties (for seller)"|t}</a></div>
	<div class="menu_item_wrapper"><a href="admin/prop_buyer.php" >{"Product Properties (for buyer)"|t}</a></div>
  </div>
</div>
<div class="menu_categ_wrapper">
  <div class="menu_categ_header"><img src="templates/admin_default/images/icons/ico1.gif" align="left">&nbsp;&nbsp;{"Content"|t}</div>
  <div class="menu_items_wrapper" id="menu_items_wrapper_1">
    <div class="menu_item_wrapper"><a href="admin/faq.php" >{"Manage"|t} FAQ</a></div>
	<div class="menu_item_wrapper"><a href="admin/ttips.php" >{"Manage Technical Tips"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/stips.php" >{"Manage Seller Tips"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/letters.php" >{"Email templates"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/simplemain.php" >{"Edit text on main page"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/simple.php" >{"Edit Text Pages"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/subscribe.php" >{"Send News"|t}</a>		</div>
  </div>
</div>
<div class="menu_categ_wrapper">
  <div class="menu_categ_header"><img src="templates/admin_default/images/icons/ico2.gif" align="left">&nbsp;&nbsp;{"Member Content"|t}</div>
  <div class="menu_items_wrapper" id="menu_items_wrapper_1">
	<div class="menu_item_wrapper"><a href="admin/pphoto.php" >{"Manage Profiles Photo"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/reviews.php" >{"Manage Reviews"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/flags.php" >{"Flagged Content"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/city.php" >{"Edit City"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/books.php" >{"Edit products for sale"|t}</a>		</div>
	<div class="menu_item_wrapper"><a href="admin/wbooks.php" >{"Edit Wanted products"|t}</a>		</div>
  </div>
</div>
<div class="menu_categ_wrapper">
  <div class="menu_categ_header"><img src="templates/admin_default/images/icons/ico2.gif" align="left">&nbsp;&nbsp;{"Settings"|t}</div>
  <div class="menu_items_wrapper" id="menu_items_wrapper_1">
    <div class="menu_item_wrapper"><a href="admin/global_settings.php" >{"Admin Password"|t}</a></div>
    <div class="menu_item_wrapper"><a href="admin/site.php" >{"Site settings"|t}</a></div>
    <div class="menu_item_wrapper"><a href="admin/currency.php" >{"Currency settings"|t}</a>		</div>
    <div class="menu_item_wrapper"><a href="admin/template.php" >{"Template settings"|t}</a></div>
    <div class="menu_item_wrapper"><a href="admin/languages.php" >{"Language settings"|t}</a></div>
    <div class="menu_item_wrapper"><a href="admin/stat_banners.php" >{"Banner Statistic"|t}</a>		</div>
    <div class="menu_item_wrapper"><a href="admin/menu.php" >{"Edit Main Menu"|t}</a>		</div>
  </div>
</div>

{$menu_block}

<div class="menu_categ_wrapper">
  <div class="menu_categ_header"><img src="templates/admin_default/images/icons/ico3.gif" align="left">&nbsp;&nbsp;<a href="admin/login.php?admin_logout">{"Logout"|t}</a></div>
</div>
</div>
<div class="clear_both"></div>

				<div style="text-align:center; margin:20px;" id="main_cont">
						{$menu_block2}
				</div>
			</div>
			{$activate_content}
			<div class="main_cont" id="main_cont" >
				<div class="page_header">{$page_header_text}</div>
				<div class="page_cont">
			<div class="admin_block" >
		<div class="block_cont">



