<link rel="stylesheet" type="text/css" href="style_selector/style_selector.css">
<script type="text/javascript" src="style_selector/style_selector.js"></script>
<div class="style-selector hide-on-mobile<?php echo (isset($_COOKIE['cm_style_selector']) ? ' ' . $_COOKIE['cm_style_selector'] : ' opened'); ?>">
	<div class="style-selector-icon">
		&nbsp;
	</div>
	<div class="style-selector-content">
		<h4>Style Selector</h4>
		<ul>
			<li class="clearfix">
				<label>Menu Type</label>
				<select name="menu_type">
					<option value="sticky"<?php echo (!isset($_COOKIE['cm_menu_type']) || $_COOKIE['cm_menu_type']=="sticky" ? ' selected="selected"' : ''); ?>>Sticky</option>
					<option value="no_sticky"<?php echo (isset($_COOKIE['cm_menu_type']) && $_COOKIE['cm_menu_type']=="no_sticky" ? ' selected="selected"' : ''); ?>>Normal</option>
				</select>
			</li>
			<li class="clearfix">
				<label>Header Type</label>
				<select name="header_type">
					<option value="type_1"<?php echo (!isset($_COOKIE['cm_header_type']) || $_COOKIE['cm_header_type']=="type_1" ? ' selected="selected"' : ''); ?>>Type 1</option>
					<option value="type_2"<?php echo (isset($_COOKIE['cm_header_type']) && $_COOKIE['cm_header_type']=="type_2" ? ' selected="selected"' : ''); ?>>Type 2</option>
				</select>
			</li>
			<li class="clearfix">
				<label>Top Bar</label>
				<select name="header_top_bar">
					<option value="no"<?php echo (!isset($_COOKIE['cm_header_top_bar']) || $_COOKIE['cm_header_top_bar']=="no" ? ' selected="selected"' : ''); ?>>No</option>
					<option value="yes"<?php echo (isset($_COOKIE['cm_header_top_bar']) && $_COOKIE['cm_header_top_bar']=="yes" ? ' selected="selected"' : ''); ?>>Yes</option>
				</select>
			</li>
			<li class="clearfix">
				<label>Layout Style</label>
				<select name="layout_style">
					<option value="wide"<?php echo (!isset($_COOKIE['cm_layout']) || $_COOKIE['cm_layout']=="" ? ' selected="selected"' : ''); ?>>Wide</option>
					<option value="boxed"<?php echo ($_COOKIE['cm_layout']=="boxed" ? ' selected="selected"' : ''); ?>>Boxed</option>
				</select>
			</li>
			<li class="clearfix">
				<label>Boxed Layout Pattern</label>
				<ul class="layout-chooser">
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-1' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-1">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-2' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-2">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-3' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-3">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-4' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-4">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-5' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-5">
							<span class="tick"></span>
						</a>
					</li>
					<li class="first<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-6' ? ' selected' : ''); ?>">
						<a href="#" class="pattern-6">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-7' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-7">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-8' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-8">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-9' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-9">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='pattern-10' ? ' class="selected"' : ''); ?>>
						<a href="#" class="pattern-10">
							<span class="tick"></span>
						</a>
					</li>
				</ul>
			</li>
			<li class="clearfix">
				<label>Boxed Layout Image</label>
				<ul class="layout-chooser">
					<li<?php echo (!isset($_COOKIE['cm_layout_style']) || (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='image-1') ? ' class="selected"' : ''); ?>>
						<a href="#" class="image-1">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='image-2' ? ' class="selected"' : ''); ?>>
						<a href="#" class="image-2">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='image-3' ? ' class="selected"' : ''); ?>>
						<a href="#" class="image-3">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='image-4' ? ' class="selected"' : ''); ?>>
						<a href="#" class="image-4">
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['cm_layout_style']) && $_COOKIE['cm_layout_style']=='image-5' ? ' class="selected"' : ''); ?>>
						<a href="#" class="image-5">
							<span class="tick"></span>
						</a>
					</li>
					<li class="first">
						<input type="checkbox"<?php echo ((isset($_COOKIE['cm_image_overlay']) && $_COOKIE['cm_image_overlay']=='overlay') || !isset($_COOKIE['cm_image_overlay']) ? ' checked="checked"' : ''); ?> id="overlay"><label class="overlay-label" for="overlay">overlay</label>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
