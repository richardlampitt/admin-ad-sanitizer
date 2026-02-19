<?php

defined('ABSPATH') || exit; // exit if accessed directly.

/*
 * Plugin Name: Admin Advertisement Sanitizer
 * Description: Hides obnoxious advertisements & upsells, notices hijacked for advertisements, and review nags in the administration area.
 * Version: 1.0.2
 * License: GPL3+
 * Requires PHP: 7.4
 * Requires at least: 5.0
*/

/*
 * Changelog:
 * 1.0.2 - Added: Profile Builder
 * 1.0.1 - Added: Enhanced Text Widget
 * 1.0.0 - Added: AIO Plugins and Elements Kit
 */

class Admin_Ad_Sanitizer {

  public function admin_ad_disable_css() { ?>
    <style>
      /* ////////////////////////////////////////////////////// */
      /* region Admin Area Upsell Disable */

      /* ====================================== */
      /* region Completely disable the most egregious nags: */

      /* ACF ---------------------------------- */
      #post-body #acf-field-group-pro-features,

        /* AIO Plugins -------------------------- */
      .notice:has([href*="https://wpmet.com/deals"]),
      .notice:has([href*="https://wpmet.com/elementskit-pricing"]),

        /* Bootstrap Blocks --------------------- */
      .bootstrap-notice.notice.notice-alt.notice-large.notice-success,

        /* CleaverPlugins ----------------------- */
      .cp-ddp-newsletter,
      [data-dismissible*="ddp-newsletter"],

        /* Duplicate pages ---------------------- */
      .duplicate_page_settings .r_dpmrs,
      .duplicate_page_settings .l_dpmrs,
      .duplicate_page_settings h1 > a,
      #new-bb-banner,

        /* Enhanced Text Widget ----------------- */
      #tifm_new_feature_notice,
      .notice:has(span[class*="tifm-grow"]),
      .notice:has(a[href*="plugins.php?s=Enhanced%20Text%20Widget"]),

        /* Monster Insights --------------------- */
      #monterinsights-admin-menu-tooltip,
      .monsterinsights-metabox-pro-badge,
      .monsterinsights-wooedd-upsell-left,
      .monsterinsights-wooedd-upsell-right,
      .monsterinsights-wooedd-upsell-image,
      .monsterinsights-wooedd-upsell-image-small,
      .monsterinsights-wooedd-upsell-row,
      .monsterinsights-wooedd-upsell-left,

        /* Podcast Player ----------------------- */
      .pp-welcome-notice .pp-link:has([href*="review"]),

        /* Press Permit ------------------------- */
      .pp-version-notice-bold-purple,

        /* Profile Builder ---------------------- */
      .pms-cross-promo,

        /* Profile Extra Fields / Best Web Soft - */
      .bws_banner_on_plugin_page,
      .bws_go_pro_banner,

        /* RankMath ----------------------------- */
      .rank-math-content-ai-box,
      #rank_math_metabox_content_ai,
      #rank_math_pro_notice,
      .eael-black-friday-notice,

        /* Really Simple SSL -------------------- */
      .rsssl-premium,
      [class*=".rsssl-premium"],
      .rsssl-support.rsssl-disabled,
      .rsssl-premium ~ p,
      .rsssl-premium ~ a,
      [class*="rsssl"] a[href$="/pro"],

        /* RevSlider ---------------------------- */
      #rso_menu_notices,
      #rs_notice_the_bell,
      [id^="rs_advert"],
      .rs_wp_plg_act_wrapper,

        /* Simple History ----------------------- */
      .sh-PremiumFeaturesPostbox,

        /* Updraft ------------------------------ */
      .updraft-ad-container,
      .updraft_premium,
      .updraft_feat_table__title,
      .updraft_feat_table,

        /* WordFence ---------------------------- */
      .wf-waf-coverage > li:nth-of-type(3), /* Premium notice */

        /* WP Bakery ---------------------------- */
      #vc_license-activation-notice,

        /* WP Forms ----------------------------- */
      .wpforms-dash-widget-block-upgrade,

        /* WP-optimize -------------------------- */
      #wp-optimize-dashnotice,

        /* WDS Promos --------------------------- */
      .wdspromos,

        /* Yoast -------------------------------- */
      .yoast #sidebar-container.wpseo_content_cell,
      .yoast_premium_upsell,
      #end-selectors-list {
        display: none !important;
      }

      /* endregion */
      /* ====================================== */

      /* ====================================== */
      /* region Remove disabled functionality: */

      .monsterinsights-metabox input[disabled],
      .monsterinsights-metabox input[disabled] + label,
      .monsterinsights-metabox input[disabled] + span,
      .monsterinsights-metabox .monsterinsights-metabox-pro-badge {
        display: none;
      }

      .notice.notice-error.rank-math-notice,
      .notice.notice-success.rank-math-notice {
        display: none;
      }

      /* endregion */
      /* ====================================== */

      /* ====================================== */
      /* region De-emphasis on less annoying things: */

      /* Contact Form Redirect :: wpcf7-redirect */
      .fs-submenu-item.pricing.upgrade-mode,

        /* Moster Insights */
      #adminmenu .monsterinsights-highlight,
      .monsterinsights-submenu-highlight,

        /* Some plugins will add style attributes directly */
      #adminmenu {
        & .upgrade,
        & [style*="color:"],
        & [style*="background-color:"],
        & [href*="utm_"],
        & [href*="upgrade"],
        & [href*="premium"] {
          &,
          & span,
          & div,
          &:hover,
          &:hover span,
          &:hover div {
            background: inherit !important;
            color: inherit !important;
          }
        }
      }

      /* endregion */
      /* ====================================== */

      /* ====================================== */
      /* region Discorage clicking on trackers: */

      #adminmenu [href*="utm_"] {
        &,
        & span,
        & div,
        &:hover,
        &:hover span,
        &:hover div {
          opacity: 0.5 !important;
        }
      }

      /* endregion */
      /* ====================================== */

      /* endregion */
      /* ////////////////////////////////////////////////////// */
    </style>
  <?php }

  public function __construct() {
    add_action('admin_head', [ $this, 'admin_ad_disable_css' ], PHP_INT_MAX);
  }
}

new Admin_Ad_Sanitizer();
