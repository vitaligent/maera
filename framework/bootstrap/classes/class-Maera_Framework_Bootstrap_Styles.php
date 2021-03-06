<?php

if ( ! class_exists( 'Maera_Framework_Bootstrap_Styles' ) ) {

	/**
	* The Bootstrap Framework module
	*/
	class Maera_Framework_Bootstrap_Styles {


		/**
		 * Class constructor
		 */
		public function __construct() {

			// Add the custom CSS
			add_action( 'wp_enqueue_scripts', array( $this, 'custom_css' ), 105 );

			// Styles
			add_filter( 'maera/styles', array( $this, 'header_css' ) );
			add_filter( 'maera/styles', array( $this, 'typography_css' ) );
			add_filter( 'maera/styles', array( $this, 'layout_css' ) );
			add_filter( 'maera/styles', array( $this, 'color_css' ) );

			add_action( 'wp_print_styles', array( $this, 'google_font' ) );

			add_filter( 'maera/compiler/variables', array( $this, 'compiler_variables' ) );

		}


		/**
		 * Get the variables from the theme options and parse them all together.
		 *
		 * These will then be added to the compiler using the "maera/compiler/variables" filter
		 */
		function compiler_variables( $variables ) {

			/**
			 * BACKGROUND
			 */
			$body_bg = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'body_bg_color', '#ffffff' ) ) );

			// Calculate the gray shadows based on the body background.
			// We basically create 2 "presets": light and dark.
			if ( Maera_Color::get_brightness( $body_bg ) > 80 ) {
				$gray_darker  = 'lighten(#000, 13.5%)';
				$gray_dark    = 'lighten(#000, 20%)';
				$gray         = 'lighten(#000, 33.5%)';
				$gray_light   = 'lighten(#000, 60%)';
				$gray_lighter = 'lighten(#000, 93.5%)';
			} else {
				$gray_darker  = 'darken(#fff, 13.5%)';
				$gray_dark    = 'darken(#fff, 20%)';
				$gray         = 'darken(#fff, 33.5%)';
				$gray_light   = 'darken(#fff, 60%)';
				$gray_lighter = 'darken(#fff, 93.5%)';
			}

			$bg_brightness = Maera_Color::get_brightness( $body_bg );

			$table_bg_accent      = $bg_brightness > 50 ? 'darken(@body-bg, 2.5%)'    : 'lighten(@body-bg, 2.5%)';
			$table_bg_hover       = $bg_brightness > 50 ? 'darken(@body-bg, 4%)'      : 'lighten(@body-bg, 4%)';
			$table_border_color   = $bg_brightness > 50 ? 'darken(@body-bg, 13.35%)'  : 'lighten(@body-bg, 13.35%)';
			$input_border         = $bg_brightness > 50 ? 'darken(@body-bg, 20%)'     : 'lighten(@body-bg, 20%)';
			$dropdown_divider_top = $bg_brightness > 50 ? 'darken(@body-bg, 10.2%)'   : 'lighten(@body-bg, 10.2%)';

			$variables = '';

			// Calculate grays
			if ( '#ffffff' != $body_bg || '#FFFFFF' != $body_bg ) {
				$variables .= '@gray-darker:            ' . $gray_darker . ';';
				$variables .= '@gray-dark:              ' . $gray_dark . ';';
				$variables .= '@gray:                   ' . $gray . ';';
				$variables .= '@gray-light:             ' . $gray_light . ';';
				$variables .= '@gray-lighter:           ' . $gray_lighter . ';';

				// The below are declared as #fff in the default variables.
				$variables .= '@body-bg:                     ' . $body_bg . ';';
				$variables .= '@component-active-color:          @body-bg;';
				$variables .= '@btn-default-bg:                  @body-bg;';
				$variables .= '@dropdown-bg:                     @body-bg;';
				$variables .= '@pagination-bg:                   @body-bg;';
				$variables .= '@progress-bar-color:              @body-bg;';
				$variables .= '@list-group-bg:                   @body-bg;';
				$variables .= '@panel-bg:                        @body-bg;';
				$variables .= '@panel-primary-text:              @body-bg;';
				$variables .= '@pagination-active-color:         @body-bg;';
				$variables .= '@pagination-disabled-bg:          @body-bg;';
				$variables .= '@tooltip-color:                   @body-bg;';
				$variables .= '@popover-bg:                      @body-bg;';
				$variables .= '@popover-arrow-color:             @body-bg;';
				$variables .= '@label-color:                     @body-bg;';
				$variables .= '@label-link-hover-color:          @body-bg;';
				$variables .= '@modal-content-bg:                @body-bg;';
				$variables .= '@badge-color:                     @body-bg;';
				$variables .= '@badge-link-hover-color:          @body-bg;';
				$variables .= '@badge-active-bg:                 @body-bg;';
				$variables .= '@carousel-control-color:          @body-bg;';
				$variables .= '@carousel-indicator-active-bg:    @body-bg;';
				$variables .= '@carousel-indicator-border-color: @body-bg;';
				$variables .= '@carousel-caption-color:          @body-bg;';
				$variables .= '@close-text-shadow:       0 1px 0 @body-bg;';
				$variables .= '@input-bg:                        @body-bg;';
				$variables .= '@nav-open-link-hover-color:       @body-bg;';

				// These are #ccc
				// We re-calculate the color based on the gray values above.
				$variables .= '@btn-default-border:            mix(@gray-light, @gray-lighter);';
				$variables .= '@input-border:                  mix(@gray-light, @gray-lighter);';
				$variables .= '@popover-fallback-border-color: mix(@gray-light, @gray-lighter);';
				$variables .= '@breadcrumb-color:              mix(@gray-light, @gray-lighter);';
				$variables .= '@dropdown-fallback-border:      mix(@gray-light, @gray-lighter);';

				$variables .= '@table-bg-accent:    ' . $table_bg_accent . ';';
				$variables .= '@table-bg-hover:     ' . $table_bg_hover . ';';
				$variables .= '@table-border-color: ' . $table_border_color . ';';

				$variables .= '@legend-border-color: @gray-lighter;';
				$variables .= '@dropdown-divider-bg: @gray-lighter;';

				$variables .= '@dropdown-link-hover-bg: @table-bg-hover;';
				$variables .= '@dropdown-caret-color:   @gray-darker;';

				$variables .= '@nav-tabs-border-color:                   @table-border-color;';
				$variables .= '@nav-tabs-active-link-hover-border-color: @table-border-color;';
				$variables .= '@nav-tabs-justified-link-border-color:    @table-border-color;';

				$variables .= '@pagination-border:          @table-border-color;';
				$variables .= '@pagination-hover-border:    @table-border-color;';
				$variables .= '@pagination-disabled-border: @table-border-color;';

				$variables .= '@tooltip-bg: darken(@gray-darker, 15%);';

				$variables .= '@popover-arrow-outer-fallback-color: @gray-light;';

				$variables .= '@modal-content-fallback-border-color: @gray-light;';
				$variables .= '@modal-backdrop-bg:                   darken(@gray-darker, 15%);';
				$variables .= '@modal-header-border-color:           lighten(@gray-lighter, 12%);';

				$variables .= '@progress-bg: ' . $table_bg_hover . ';';

				$variables .= '@list-group-border:   ' . $table_border_color . ';';
				$variables .= '@list-group-hover-bg: ' . $table_bg_hover . ';';

				$variables .= '@list-group-link-color:         @gray;';
				$variables .= '@list-group-link-heading-color: @gray-dark;';

				$variables .= '@panel-inner-border:       @list-group-border;';
				$variables .= '@panel-footer-bg:          @list-group-hover-bg;';
				$variables .= '@panel-default-border:     @table-border-color;';
				$variables .= '@panel-default-heading-bg: @panel-footer-bg;';

				$variables .= '@thumbnail-border: @list-group-border;';

				$variables .= '@well-bg: @table-bg-hover;';

				$variables .= '@breadcrumb-bg: @table-bg-hover;';

				$variables .= '@close-color: darken(@gray-darker, 15%);';
			}

			/**
			 * LAYOUT
			 */
			$screen_sm = filter_var( get_theme_mod( 'screen_tablet', 768 ), FILTER_SANITIZE_NUMBER_INT );
			$screen_md = filter_var( get_theme_mod( 'screen_desktop', 992 ), FILTER_SANITIZE_NUMBER_INT );
			$screen_lg = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
			$gutter    = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );
			$gutter    = ( $gutter < 2 ) ? 2 : $gutter;

			$site_style = get_theme_mod( 'site_style', 'wide' );

			$screen_xs = ( $site_style == 'static' ) ? '50px' : '480px';
			$screen_sm = ( $site_style == 'static' ) ? '50px' : $screen_sm;
			$screen_md = ( $site_style == 'static' ) ? '50px' : $screen_md;

			$variables .= '@screen-sm: ' . $screen_sm . 'px;';
			$variables .= '@screen-md: ' . $screen_md . 'px;';
			$variables .= '@screen-lg: ' . $screen_lg . 'px;';
			$variables .= '@grid-gutter-width: ' . $gutter . 'px;';

			$variables .= '@jumbotron-padding: @grid-gutter-width;';

			$variables .= '@modal-inner-padding: ' . round( $gutter * 20 / 30 ) . 'px;';
			$variables .= '@modal-title-padding: ' . round( $gutter * 15 / 30 ) . 'px;';

			$variables .= '@modal-lg: ' . round( $screen_md - ( 3 * $gutter ) ) . 'px;';
			$variables .= '@modal-md: ' . round( $screen_sm - ( 3 * $gutter ) ) . 'px;';
			$variables .= '@modal-sm: ' . round( $screen_xs - ( 3 * $gutter ) ) . 'px;';

			$variables .= '@panel-body-padding: @modal-title-padding;';

			$variables .= '@container-tablet:        ' . ( $screen_sm - ( $gutter / 2 ) ). 'px;';
			$variables .= '@container-desktop:       ' . ( $screen_md - ( $gutter / 2 ) ). 'px;';
			$variables .= '@container-large-desktop: ' . ( $screen_lg - $gutter ). 'px;';

			if ( $site_style == 'static' ) {
				// disable responsiveness
				$variables .= '@screen-xs-max: 0 !important;
				.container { max-width: none !important; width: @container-large-desktop; }
				html { overflow-x: auto !important; }';
			}

			/**
			 * BRANDING
			 */
			$brand_primary = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_primary', '#428bca' ) ) );
			$brand_success = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_success', '#5cb85c' ) ) );
			$brand_warning = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_warning', '#f0ad4e' ) ) );
			$brand_danger  = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_danger', '#d9534f' ) ) );
			$brand_info    = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_info', '#5bc0de' ) ) );

			$link_hover_color = ( Maera_Color::get_brightness( $brand_primary ) > 50 ) ? 'darken(@link-color, 15%)' : 'lighten(@link-color, 15%)';

			$brand_primary_brightness = Maera_Color::get_brightness( $brand_primary );
			$brand_success_brightness = Maera_Color::get_brightness( $brand_success );
			$brand_warning_brightness = Maera_Color::get_brightness( $brand_warning );
			$brand_danger_brightness  = Maera_Color::get_brightness( $brand_danger );
			$brand_info_brightness    = Maera_Color::get_brightness( $brand_info );

			// Button text colors
			$btn_primary_color  = $brand_primary_brightness < 195 ? '#fff' : '333';
			$btn_success_color  = $brand_success_brightness < 195 ? '#fff' : '333';
			$btn_warning_color  = $brand_warning_brightness < 195 ? '#fff' : '333';
			$btn_danger_color   = $brand_danger_brightness  < 195 ? '#fff' : '333';
			$btn_info_color     = $brand_info_brightness    < 195 ? '#fff' : '333';

			// Button borders
			$btn_primary_border = $brand_primary_brightness < 195 ? 'darken(@btn-primary-bg, 5%)' : 'lighten(@btn-primary-bg, 5%)';
			$btn_success_border = $brand_success_brightness < 195 ? 'darken(@btn-success-bg, 5%)' : 'lighten(@btn-success-bg, 5%)';
			$btn_warning_border = $brand_warning_brightness < 195 ? 'darken(@btn-warning-bg, 5%)' : 'lighten(@btn-warning-bg, 5%)';
			$btn_danger_border  = $brand_danger_brightness  < 195 ? 'darken(@btn-danger-bg, 5%)'  : 'lighten(@btn-danger-bg, 5%)';
			$btn_info_border    = $brand_info_brightness    < 195 ? 'darken(@btn-info-bg, 5%)'    : 'lighten(@btn-info-bg, 5%)';

			$input_border_focus = ( Maera_Color::get_brightness( $brand_primary ) < 195 ) ? 'lighten(@brand-primary, 10%)' : 'darken(@brand-primary, 10%)';
			$navbar_border      = ( Maera_Color::get_brightness( $brand_primary ) < 50 ) ? 'lighten(@navbar-default-bg, 6.5%)' : 'darken(@navbar-default-bg, 6.5%)';

			// Branding colors
			$variables .= '@brand-primary: ' . $brand_primary . ';';
			$variables .= '@brand-success: ' . $brand_success . ';';
			$variables .= '@brand-info:    ' . $brand_info . ';';
			$variables .= '@brand-warning: ' . $brand_warning . ';';
			$variables .= '@brand-danger:  ' . $brand_danger . ';';

			// Link-hover
			$variables .= '@link-hover-color: ' . $link_hover_color . ';';

			$variables .= '@btn-default-color:  @gray-dark;';

			$variables .= '@btn-primary-color:  ' . $btn_primary_color . ';';
			$variables .= '@btn-primary-border: ' . $btn_primary_border . ';';
			$variables .= '@btn-success-color:  ' . $btn_success_color . ';';
			$variables .= '@btn-success-border: ' . $btn_success_border . ';';
			$variables .= '@btn-info-color:     ' . $btn_info_color . ';';
			$variables .= '@btn-info-border:    ' . $btn_info_border . ';';
			$variables .= '@btn-warning-color:  ' . $btn_warning_color . ';';
			$variables .= '@btn-warning-border: ' . $btn_warning_border . ';';
			$variables .= '@btn-danger-color:   ' . $btn_danger_color . ';';
			$variables .= '@btn-danger-border:  ' . $btn_danger_border . ';';
			$variables .= '@input-border-focus: ' . $input_border_focus . ';';

			$variables .= '@state-success-text: mix(@gray-darker, @brand-success, 20%);';
			$variables .= '@state-success-bg:   mix(@body-bg, @brand-success, 50%);';

			$variables .= '@state-info-text:    mix(@gray-darker, @brand-info, 20%);';
			$variables .= '@state-info-bg:      mix(@body-bg, @brand-info, 50%);';

			$variables .= '@state-warning-text: mix(@gray-darker, @brand-warning, 20%);';
			$variables .= '@state-warning-bg:   mix(@body-bg, @brand-warning, 50%);';

			$variables .= '@state-danger-text:  mix(@gray-darker, @brand-danger, 20%);';
			$variables .= '@state-danger-bg:    mix(@body-bg, @brand-danger, 50%);';

			$padding_base  = intval( get_theme_mod( 'padding_base', 8 ) );

			$border_radius = filter_var( get_theme_mod( 'border_radius', 4 ), FILTER_SANITIZE_NUMBER_INT );
			$border_radius = ( strlen( $border_radius ) < 1 ) ? 0 : $border_radius;

			$variables .= '@padding-base-vertical:    ' . round( $padding_base * 6 / 6 ) . 'px;';
			$variables .= '@padding-base-horizontal:  ' . round( $padding_base * 12 / 6 ) . 'px;';

			$variables .= '@padding-large-vertical:   ' . round( $padding_base * 10 / 6 ) . 'px;';
			$variables .= '@padding-large-horizontal: ' . round( $padding_base * 16 / 6 ) . 'px;';

			$variables .= '@padding-small-vertical:   ' . round( $padding_base * 5 / 6 ) . 'px;';
			$variables .= '@padding-small-horizontal: @padding-large-vertical;';

			$variables .= '@padding-xs-vertical:      ' . round( $padding_base * 1 / 6 ) . 'px;';
			$variables .= '@padding-xs-horizontal:    @padding-small-vertical;';

			$variables .= '@border-radius-base:  ' . round( $border_radius * 4 / 4 ) . 'px;';
			$variables .= '@border-radius-large: ' . round( $border_radius * 6 / 4 ) . 'px;';
			$variables .= '@border-radius-small: ' . round( $border_radius * 3 / 4 ) . 'px;';

			$variables .= '@pager-border-radius: ' . round( $border_radius * 15 / 4 ) . 'px;';

			$variables .= '@tooltip-arrow-width: @padding-small-vertical;';
			$variables .= '@popover-arrow-width: (@tooltip-arrow-width * 2);';

			$variables .= '@thumbnail-padding:         ' . round( $padding_base * 4 / 6 ) . 'px;';
			$variables .= '@thumbnail-caption-padding: ' . round( $padding_base * 9 / 6 ) . 'px;';

			$variables .= '@badge-border-radius: ' . round( $border_radius * 10 / 4 ) . 'px;';

			$variables .= '@breadcrumb-padding-vertical:   ' . round( $padding_base * 8 / 6 ) . 'px;';
			$variables .= '@breadcrumb-padding-horizontal: ' . round( $padding_base * 15 / 6 ) . 'px;';

			/**
			 * MENUS
			 */
			$font_navbar       = get_theme_mod( 'font_menus_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
			$font_brand        = $font_navbar;
			$navbar_bg         = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'navbar_bg', '#f8f8f8' ) ) );
			$navbar_height     = filter_var( get_theme_mod( 'navbar_height', 50 ), FILTER_SANITIZE_NUMBER_INT );
			$navbar_text_color = '#' . str_replace( '#', '', get_theme_mod( 'font_menus_color', '#333333' ) );
			$brand_text_color  = $navbar_text_color;
			$navbar_border     = ( Maera_Color::get_brightness( $navbar_bg ) < 50 ) ? 'lighten(@navbar-default-bg, 6.5%)' : 'darken(@navbar-default-bg, 6.5%)';
			$gfb = get_theme_mod( 'grid_float_breakpoint', 'screen_sm_min' );

			if ( Maera_Color::get_brightness( $navbar_bg ) < 165 ) {
				$navbar_link_hover_color    = 'darken(@navbar-default-color, 26.5%)';
				$navbar_link_active_bg      = 'darken(@navbar-default-bg, 6.5%)';
				$navbar_link_disabled_color = 'darken(@navbar-default-bg, 6.5%)';
				$navbar_brand_hover_color   = 'darken(@navbar-default-brand-color, 10%)';
			} else {
				$navbar_link_hover_color    = 'lighten(@navbar-default-color, 26.5%)';
				$navbar_link_active_bg      = 'lighten(@navbar-default-bg, 6.5%)';
				$navbar_link_disabled_color = 'lighten(@navbar-default-bg, 6.5%)';
				$navbar_brand_hover_color   = 'lighten(@navbar-default-brand-color, 10%)';
			}

			$grid_float_breakpoint = ( isset( $gfb ) )           ? $gfb             : '@screen-sm-min';
			$grid_float_breakpoint = ( $gfb == 'min' )           ? '10px'           : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'screen_xs_min' ) ? '@screen-xs-min' : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'screen_sm_min' ) ? '@screen-sm-min' : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'screen_md_min' ) ? '@screen-md-min' : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'screen_lg_min' ) ? '@screen-lg-min' : $grid_float_breakpoint;
			$grid_float_breakpoint = ( $gfb == 'max' )           ? '9999px'         : $grid_float_breakpoint;

			$grid_float_breakpoint = ( $gfb == 'screen-lg-min' ) ? '0 !important' : $grid_float_breakpoint;

			$variables .= '@navbar-height:         ' . $navbar_height . 'px;';
			$variables .= '@navbar-default-color:  ' . $navbar_text_color . ';';
			$variables .= '@navbar-default-bg:     ' . $navbar_bg . ';';
			$variables .= '@navbar-default-border: ' . $navbar_border . ';';

			$variables .= '@navbar-default-link-color:          @navbar-default-color;';

			$variables .= '@navbar-default-link-hover-color:    ' . $navbar_link_hover_color . ';';

			$variables .= '@navbar-default-link-active-color:   mix(@navbar-default-color, @navbar-default-link-hover-color, 50%);';

			$variables .= '@navbar-default-link-active-bg:      ' . $navbar_link_active_bg . ';';
			$variables .= '@navbar-default-link-disabled-color: ' . $navbar_link_disabled_color . ';';

			$variables .= '@navbar-default-brand-color:         @navbar-default-link-color;';
			$variables .= '@navbar-default-brand-hover-color:   ' . $navbar_brand_hover_color . ';';
			$variables .= '@navbar-default-toggle-hover-bg:     ' . $navbar_border . ';';
			$variables .= '@navbar-default-toggle-icon-bar-bg:  ' . $navbar_text_color . ';';
			$variables .= '@navbar-default-toggle-border-color: ' . $navbar_border . ';';

			$variables .= '@grid-float-breakpoint: ' . $grid_float_breakpoint . ';';

			if ( get_theme_mod( 'gradients_toggle', 0 ) ) {
				$variables .= '@import "' . MAERA_FRAMEWORK_PATH . '/assets/less/gradients.less";';
			}

			return $variables;
		}


		/**
		* Enqueue Google fonts if enabled
		*/
		function google_font() {

			$font_base_google    = get_theme_mod( 'font_base_google', 0 );
			$font_headers_google = get_theme_mod( 'headers_font_google', 0 );

			if ( $font_base_google == 1 ) {

				$font_base_family = str_replace( ' ', '+', get_theme_mod( 'font_base_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' ) );
				$font_base_google_subsets = get_theme_mod( 'font_base_google_subsets', 'latin' );

				wp_register_style( 'maera_base_google_font', 'http://fonts.googleapis.com/css?family=' . $font_base_family . '&subset=' . $font_base_google_subsets );
		 		wp_enqueue_style( 'maera_base_google_font' );

			}


			if ( $font_headers_google == 1 ) {

				$font_headers_family = str_replace( ' ', '+', get_theme_mod( 'headers_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' ) );
				$font_headers_google_subsets = get_theme_mod( 'font_headers_google_subsets', 'latin' );

				wp_register_style( 'maera_headers_google_font', 'http://fonts.googleapis.com/css?family='.$font_headers_family.'&subset='.$font_headers_google_subsets );
		 		wp_enqueue_style( 'maera_headers_google_font' );

			}

		}


		/*
		 * Any necessary extra CSS is generated here
		 */
		function header_css( $styles ) {

			if ( 1 == get_theme_mod( 'header_toggle', 0 ) ) {

				$el = ( 'boxed' == get_theme_mod( 'site_style', 'wide' ) ) ? 'body .header-boxed' : 'body .header-wrapper';
				$styles .= $el . ',' . $el . ' a,' . $el . ' h1,' . $el . ' h2,' . $el . ' h3,' . $el . ' h4,' . $el . ' h5,' . $el . ' h6{ color:' . get_theme_mod( 'header_color', '#333333') . ';}';

			}

		}


		/**
		 * CSS rules for typography options
		 */
		function typography_css( $style ) {

			// Base font settings
			$font_base_family    = get_theme_mod( 'font_base_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );
			$font_base_google    = get_theme_mod( 'font_base_google', 0 );
			$font_base_color     = get_theme_mod( 'font_base_color', '#333333' );
			$font_base_weight    = get_theme_mod( 'font_base_weight', '#333333' );
			$font_base_size      = get_theme_mod( 'font_base_size', ( 'px' == get_theme_mod( 'font_size_units', 'px' ) ) ? 14 : 1.5 );
			$font_base_height    = get_theme_mod( 'font_base_height', 1.4 );

			$style .= 'body {font-family:' . $font_base_family . ';color:' . $font_base_color . ';font-weight:' . $font_base_weight . ';font-size:' . $font_base_size . get_theme_mod( 'font_size_units', 'px' ) . ';line-height:' . $font_base_height . ';}';

			// Headers font
			$headers_font_family = get_theme_mod( 'headers_font_family', '"Helvetica Neue", Helvetica, Arial, sans-serif' );

			$style .= 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6{';
			$style .= 'font-family: ' . $headers_font_family . ';';
			$style .= 'color: ' . get_theme_mod( 'font_headers_color', '#333333' ) . ';';
			$style .= 'font-weight: ' . get_theme_mod( 'font_headers_weight', 400 ) . ';';
			$style .= 'line-height: ' . get_theme_mod( 'font_headers_height', 1.1 ) . ';';
			$style .= '}';

			$style .= 'h1, .h1 { font-size: ' . intval( ( 260 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h2, .h2 { font-size: ' . intval( ( 215 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h3, .h3 { font-size: ' . intval( ( 170 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h4, .h4 { font-size: ' . intval( ( 110 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h5, .h5 { font-size: ' . intval( ( 100 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';
			$style .= 'h6, .h6 { font-size: ' . intval( ( 85 / 215 ) * get_theme_mod( 'font_headers_size', 215 ) ) . '%; }';

			return $style;

		}


		/**
		 * Additional CSS rules for layout options
		 */
		function layout_css( $style ) {

			global $wp_customize;

			// Customizer-only styles
			if ( $wp_customize ) {

				$screen_sm = filter_var( get_theme_mod( 'screen_tablet', 768 ), FILTER_SANITIZE_NUMBER_INT );
				$screen_md = filter_var( get_theme_mod( 'screen_desktop', 992 ), FILTER_SANITIZE_NUMBER_INT );
				$screen_lg = filter_var( get_theme_mod( 'screen_large_desktop', 1200 ), FILTER_SANITIZE_NUMBER_INT );
				$gutter    = filter_var( get_theme_mod( 'gutter', 30 ), FILTER_SANITIZE_NUMBER_INT );

				$style .= '
				.container {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}
				@media (min-width: ' . $screen_sm . 'px) {
					.container {
						width: ' . ( $screen_sm - ( $gutter / 2 ) ). 'px;
					}
				}
				@media (min-width: ' . $screen_lg . 'px) {
					.container {
						width: ' . ( $screen_md - ( $gutter / 2 ) ). 'px;
					}
				}
				@media (min-width: ' . $screen_lg . 'px) {
					.container {
						width: ' . ( $screen_lg - ( $gutter / 2 ) ). 'px;
					}
				}
				.container-fluid {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}
				.row {
					margin-left: -' . round( $gutter / 2 ) . 'px;
					margin-right: -' . round( $gutter / 2 ) . 'px;
				}
				.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
					padding-left: ' . round( $gutter / 2 ) . 'px;
					padding-right: ' . round( $gutter / 2 ) . 'px;
				}';

			}

			return $style;

		}


		/**
		 * Additional CSS rules for layout options
		 */
		function color_css( $style ) {

			global $wp_customize;

			// Customizer-only styles
			if ( ! $wp_customize ) {
				return $style;
			}

			$brand_primary = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_primary', '#428bca' ) ) );
			$brand_success = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_success', '#5cb85c' ) ) );
			$brand_warning = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_warning', '#f0ad4e' ) ) );
			$brand_danger  = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_danger', '#d9534f' ) ) );
			$brand_info    = '#' . str_replace( '#', '', Maera_Color::sanitize_hex( get_theme_mod( 'color_brand_info', '#5bc0de' ) ) );

			$style .= 'a { color: ' . $brand_primary . '; }';
			$style .= '.text-primary { color: ' . $brand_primary . '; }';
			$style .= '.bg-primary { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active { background-color: ' . $brand_primary . '; }';
			$style .= '.btn-primary .badge { color: ' . $brand_primary . '; }';
			$style .= '.btn-link { color: ' . $brand_primary . '; }';
			$style .= '.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus { background-color: ' . $brand_primary . '; }';
			$style .= '.pagination > li > a, .pagination > li > span { color: ' . $brand_primary . '; }';
			$style .= '.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus { background-color: ' . $brand_primary . '; border-color: ' . $brand_primary . '; }';

			$style .= '.text-info { color: ' . $brand_info . '; }';
			$style .= '.bg-info { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info.disabled, .btn-info[disabled], fieldset[disabled] .btn-info, .btn-info.disabled:hover, .btn-info[disabled]:hover, fieldset[disabled] .btn-info:hover, .btn-info.disabled:focus, .btn-info[disabled]:focus, fieldset[disabled] .btn-info:focus, .btn-info.disabled:active, .btn-info[disabled]:active, fieldset[disabled] .btn-info:active, .btn-info.disabled.active, .btn-info[disabled].active, fieldset[disabled] .btn-info.active { background-color: ' . $brand_info . '; }';
			$style .= '.btn-info .badge { color: ' . $brand_info . '; }';

			$style .= '.text-warning { color: ' . $brand_warning . '; }';
			$style .= '.bg-warning { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning.disabled, .btn-warning[disabled], fieldset[disabled] .btn-warning, .btn-warning.disabled:hover, .btn-warning[disabled]:hover, fieldset[disabled] .btn-warning:hover, .btn-warning.disabled:focus, .btn-warning[disabled]:focus, fieldset[disabled] .btn-warning:focus, .btn-warning.disabled:active, .btn-warning[disabled]:active, fieldset[disabled] .btn-warning:active, .btn-warning.disabled.active, .btn-warning[disabled].active, fieldset[disabled] .btn-warning.active { background-color: ' . $brand_warning . '; }';
			$style .= '.btn-warning .badge { color: ' . $brand_warning . '; }';

			$style .= '.text-danger { color: ' . $brand_danger . '; }';
			$style .= '.bg-danger { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger.disabled, .btn-danger[disabled], fieldset[disabled] .btn-danger, .btn-danger.disabled:hover, .btn-danger[disabled]:hover, fieldset[disabled] .btn-danger:hover, .btn-danger.disabled:focus, .btn-danger[disabled]:focus, fieldset[disabled] .btn-danger:focus, .btn-danger.disabled:active, .btn-danger[disabled]:active, fieldset[disabled] .btn-danger:active, .btn-danger.disabled.active, .btn-danger[disabled].active, fieldset[disabled] .btn-danger.active { background-color: ' . $brand_danger . '; }';
			$style .= '.btn-danger .badge { color: ' . $brand_danger . '; }';

			return $style;

		}


		/**
		 * Include the custom CSS
		 */
		function custom_css() {
			$css = get_theme_mod( 'css', '' );

			if ( ! empty( $css ) ) {
				wp_add_inline_style( 'maera', $css );
			}
		}

	}

}
