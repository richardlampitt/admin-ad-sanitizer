<?php

defined('ABSPATH') || exit; // exit if accessed directly.

/*
 * Plugin Name: Admin Advertisement Sanitizer
 * Description: Hides obnoxious advertisements & upsells, notices hijacked for advertisements, and review nags in the administration area.
 * Version: 1.1.2.3
 * License: GPL3+
 * Requires PHP: 7.4
 * Requires at least: 5.0
*/

/*
 * Changelog:
 * 1.1.2.3  - Bugfix: Disable over-ambitious cookie date causing fatal error.
 * 1.1.2.2  - Added: ThemeHunk Mega Menu class override.
 * 1.1.2.1  - Added: ThemeHunk Mega Menu admin advertisements.
 * 1.1.2    - Added: ThemeHunk Mega Menu advertisement slider.
 * 1.1.1.10 - Added: Astra remove starter templates cross-sell.
 * 1.1.1.9  - Added: Astra remove site-builder bait-and-switch.
 * 1.1.1.8  - Added: Astra dashboard disabled features.
 * 1.1.1.7  - Bugfix: Fix incorrect selector.
 * 1.1.1.6  - Added: Astra full screen ad tab.
 * 1.1.1.5  - Added: Astra customizer fake tab.
 * 1.1.1.4  - Bugfix: Tighten specificity on selector.
 * 1.1.1.3  - Added: Astra dashboard support upsell.
 * 1.1.1.2  - Added: Astra dashboard plugin cross-sell/ disabled features.
 * 1.1.1.1  - Added: Astra dashboard disabled features.
 * 1.1.1.0  - Added: Astra Customizer huge upsell.
 * 1.1.0.1  - Bugfix: Fix missing hook.
 * 1.1.0    - Feature: Change hook to affect customizer interface.
 * 1.0.12.1 - Added: Astra Customizer disabled features.
 * 1.0.12   - Added: Astra Customizer huge upsell.
 * 1.0.11.5 - Added: Yoast external link in menu.
 * 1.0.11.4 - Bugfix: Incorrectly formatted CSS.
 * 1.0.11.3 - Added: Yoast disabled featured.
 * 1.0.11.2 - Bugfix: Overeager Selector affecting too many items.
 * 1.0.11.1 - Added: Yoast upsells.
 * 1.0.11   - Added: Yoast upsells.
 * 1.0.10.1 - Bugfix: Fix incorrect selector.
 * 1.0.10   - Added: Remove RankMath animations.
 * 1.0.9    - Added: Remove disabled RankMath functionality.
 * 1.0.8    - Added: De-emphasize RankMath Pro notice.
 * 1.0.7.1  - Bugfix: Reduce specificity of selector to prevent accidental exclusion of legitimate notices.
 * 1.0.7    - Added: Royal Elementor Addons update notification upsells.
 * 1.0.7    - Added: Elementor update notification upsells.
 * 1.0.6    - Added: UpdraftPlus massive notification upsell hijack.
 * 1.0.5.1  - Bugfix: Incorrect selector.
 * 1.0.5    - Added: Smashballoons Instagram Feed unneeded icon.
 * 1.0.4    - Added: Smashballoons Instagram Feed plugin upsell.
 * 1.0.3    - Added: Get Shortcodes.
 * 1.0.2    - Added: Profile Builder.
 * 1.0.1    - Added: Enhanced Text Widget.
 * 1.0.0    - Added: AIO Plugins and Elements Kit.
 */

class Admin_Ad_Sanitizer {

  /**
   * Determines whether Multisite is enabled.
   * Forked separately as this class may be loaded before the WP function is available
   *
   * @return bool True if Multisite is enabled, false otherwise.
   * @since 3.0.0
   *
   */
  public static function is_multisite() {
    if ( defined('MULTISITE') ) {
      return MULTISITE;
    }

    if ( defined('SUBDOMAIN_INSTALL') || defined('VHOST') || defined('SUNRISE') ) {
      return true;
    }

    return false;
  }

  /**
   * Checks if a plugin is active.
   * Forked separately as this class may be loaded before the WP function is available
   *
   * @param $plugin
   *
   * @return bool
   */
  public static function is_plugin_active($plugin) {
    return (
      in_array($plugin, (array) get_option('active_plugins', []), true) ||
      self::is_plugin_active_for_network($plugin)
    );
  }

  /**
   * Checks if a plugin is active.
   * Forked separately as this class may be loaded before the WP function is available
   *
   * @param $plugin
   *
   * @return bool
   */
  public static function is_plugin_active_for_network($plugin) {
    if ( !self::is_multisite() ) {
      return false;
    }

    $plugins = get_site_option('active_sitewide_plugins');
    if ( isset($plugins[$plugin]) ) {
      return true;
    }

    return false;
  }

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

        /* Astra -------------------------------- */
      #customize-control-astra-settings-header-builder-pro-items,
      #astra-dashboard-app section:has([d="M83.1363 60.863C81.3465 61.953 19.6523 63.0372 16.4254 60.863C13.778 59.0818 15.0372 28.0612 15.5994 15.759C15.6194 15.3288 15.6366 14.9272 15.6567 14.5429C15.7485 12.581 17.2917 10.576 19.2478 10.5129C24.0522 10.358 79.9124 9.78723 82.4221 11.0894C82.8753 11.3246 83.2453 13.0628 83.5379 15.759H83.5408C84.8745 27.9952 84.6078 59.971 83.1392 60.863H83.1363Z"]),
      #astra-dashboard-app section:has([data-action="astra_recommended_plugin_install"]),
      #astra-dashboard-app a[href*="vip-priority-support"],
      #astra-dashboard-app a[href*="page=astra&amp;path=free-vs-pro"],
      #astra-dashboard-app a[href*="page=astra&path=free-vs-pro"],
      #astra-dashboard-app a[href*="page=astra&amp;path=starter-templates"],
      #astra-dashboard-app a[href*="page=astra&path=starter-templates"],
      #customize-theme-controls li:has([href*="https://wpastra.com/pricing/"]),

        /* Bootstrap Blocks --------------------- */
      .bootstrap-notice.notice-alt.notice-large.notice-success,

        /* CleaverPlugins ----------------------- */
      .cp-ddp-newsletter,
      [data-dismissible*="ddp-newsletter"],

        /* Duplicate pages ---------------------- */
      .duplicate_page_settings .r_dpmrs,
      .duplicate_page_settings .l_dpmrs,
      .duplicate_page_settings h1 > a,
      #new-bb-banner,

        /* Elementor ---------------------------- */
      #ehe-admin-cb :not(div):not(.notice-dismiss),

        /* Enhanced Text Widget ----------------- */
      #tifm_new_feature_notice,
      .notice:has(span[class*="tifm-grow"]),
      .notice:has(a[href*="plugins.php?s=Enhanced%20Text%20Widget"]),

        /* Get Shortcodes ----------------------- */
      .su-admin-c-notice-pro:has([href*="getshortcodes.com/pricing"]),
        /*.su-admin-about-wrap:has([href*="getshortcodes.com/pricing"]),*/

        /* Instagram Feed ----------------------- */
      .sbi-new-indicator,
      #sbi-notifications .messages:has([href*="how-to-get-free-whatsapp-chat-plugin-wordpress"]),
      #sbi-notifications .messages:has([href*="?utm_source="]),
      #sbi-notifications .messages:has([href*="?utm_campaign="]),

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

        /* Royal Elementor Addons --------------- */
      .wpr-plugin-update-notice div,
      .wpr-plugin-update-notice canvas,
      #wpr-notice-confetti,

        /* Theme Hunk --------------------------- */
      .notice:has(a[href*="utm_campaign=th_plugins"]),
      .notice:has(a[href*="https://wpzita.com/royal-shop/"]),
      .th-notice-slide-wrapper,

        /* Simple History ----------------------- */
      .sh-PremiumFeaturesPostbox,

        /* Updraft ------------------------------ */
      #updraft-dashnotice,
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
      [href*="wpseo_brand_insights"]:has(.yst-external-link-icon),
      .yst-modal,
      div:has(> [class*="yst-button--upsell"]),
      a:has([class*="yst-button--upsell"]),
      a[href*="wpseo_upgrade_sidebar"],
      #end-selectors-list {
        display: none !important;
      }

      /* endregion */
      /* ====================================== */

      /* ====================================== */
      /* region Remove disabled functionality: */

      /* Astra --------------------------------- */
      .builder-add-btn.pro-feature:has(.pro-icon),
      #astra-dashboard-app a:has(.lucide-lock),
      #astra-dashboard-app section:has([href^="https://wpastra.com/pricing/"]),
      #astra-dashboard-app :has(a[href*="page=astra&path=free-vs-pro"]) a[href*="&settings=version-control"],
      #astra-dashboard-app :has(a[href*="page=astra&path=free-vs-pro"]) a[href*="&settings=white-label"],
      #toplevel_page_astra li:has(a[href*="page=theme-builder-free"]),

        /* Monster Insights ---------------------- */
      .monsterinsights-metabox input[disabled],
      .monsterinsights-metabox input[disabled] + label,
      .monsterinsights-metabox input[disabled] + span,
      .monsterinsights-metabox .monsterinsights-metabox-pro-badge,

        /* Rank Math --------------------------- */
      .rank-math-box[aria-hidden="true"],

        /* Yoast ------------------------------- */
      #adminmenu a:has(.yoast-premium-badge),
      #end-selectors-list {
        display: none !important;
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

        /* Instagram Feed */
      .sbi-cta-discount-label,

        /* Moster Insights */
      #adminmenu .monsterinsights-highlight,
      .monsterinsights-submenu-highlight,

        /* --- */
      #end-selectors-list {
        & .upgrade,
        &.upgrade,
        & [style*="color:"],
        &[style*="color:"],
        & [style*="background-color:"],
        &[style*="background-color:"],
        & [href*="utm_"],
        &[href*="utm_"],
        & [href*="upgrade"],
        &[href*="upgrade"],
        & [href*="premium"],
        &[href*="premium"] {
          &,
          & a,
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

      /* Some plugins will add style attributes directly */
      #adminmenu {
        & .upgrade,
        & [style*="color:"],
        & [style*="background-color:"],
        & [href*="utm_"],
        & [href*="upgrade"],
        & [href*="premium"] {
          &,
          & a,
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

      /* ------------------------------ */
      /* Revert any admin-menu changes */
      /* ------------------------------ */

      #adminmenu .opensub .wp-submenu li.current a,
      #adminmenu .wp-submenu li.current,
      #adminmenu .wp-submenu li.current a,
      #adminmenu a.wp-has-current-submenu:focus + .wp-submenu li.current a {
        &,
        &.upgrade,
        &[style*="color:"],
        &[style*="background-color:"],
        &[href*="utm_"],
        &[href*="upgrade"],
        &[href*="premium"] {
          &,
          & span,
          & div {
            background: transparent !important;
            color: var(--wp--preset--color--white, #fefefeff) !important;
          }

          & div,
          & span {
            border: unset !important;
            height: unset !important;
            margin: unset !important;
            position: static !important;
            display: initial !important;
            padding: unset !important;
            font: inherit !important;
            color: inherit !important;
            background: transparent !important;
          }

          &:hover,
          &:focus,
          &:focus-visible {
            &,
            & span,
            & div {
              background: transparent !important;
              color: var(--wp-admin-theme-color) !important;
            }
          }
        }
      }

      /* ------------------------------ */
      /* Revert any less-annoying notice changes: */
      /* ------------------------------ */

      #rank-math-unlock-pro-notice,
      #end-selectors-list {
        border: 1px solid #b5bfc9 !important;

        &,
        & a,
        & * {
          background: var(--wp--preset--color--white, #fefefe);
          color: var(--wp-admin-theme-color) !important;
          font-size: 13px !important;
          border: unset !important;
          font-weight: unset !important;
        }
        & strong,
        & b {
          font-weight: 600 !important;
        }
        & a {
          &:hover, &:focus, &:focus-visible {
            color: var(--wp-admin-theme-color-darker-10) !important;
          }
        }
      }

      /* ------------------------------ */
      /* Remove animations */
      /* ------------------------------ */

      #rank-math-dashboard-page *,
      #rank-math-dashboard-page .rank-math-button.components-button.button-animate,
      #end-selectors-list {
        &,
        &::before,
        &::after {
          animation: unset !important;
        }
      }

      /* endregion */
      /* ====================================== */

      /* ====================================== */
      /* region Fix update notification content: */

      .wpr-plugin-update-notice,
      .end-selectors-list {
        background: #fefefe !important;
        border: 1px solid #c3c4c7fe !important;
        border-left-color: #72aee6fe !important;
        border-left-width: 4px !important;
        box-shadow: 0 1px 1px #0000000a !important;
        padding: 0.5rem 0.75rem !important;

        &::after,
        &::before {
          content: "Updated:";
          display: inline-flex;
          align-items: center;
          line-height: 1;
          font-size: 0.8125rem;
          padding-inline-end: 0.325em;
        }
      }

      .wpr-plugin-update-notice::after {
        content: "Royal Elementor Plugins" !important;
      }

      /* Elementor Upsells */
      div:has( > .MuiBox-root .notice-dismiss) {
        display: block !important;
        background: #fefefe !important;
        border: 1px solid #c3c4c7fe !important;
        border-left-color: #72aee6fe !important;
        border-left-width: 4px !important;
        box-shadow: 0 1px 1px #0000000a !important;
        padding: 0.5rem 0.75rem !important;

        & .MuiBox-root:has(.notice-dismiss) {
          &,
          & .MuiBox-root:not(.notice-dismiss),
          & .MuiStack-root:not(.notice-dismiss),
          & .MuiPaper-root:not(.notice-dismiss) {
            padding: 0 !important;
            color: unset !important;
            transition: unset !important;
            box-shadow: unset !important;
            background-image: unset !important;
            border-radius: unset !important;
            background-color: unset !important;
            width: auto !important;
            position: relative !important;
            float: right !important;
          }
        }
        .notice-dismiss {
          padding: 0 !important;
        }

        &::after,
        &::before {
          content: "";
          display: inline-flex;
          align-items: center;
          line-height: 1;
          font-size: 0.8125rem;
          padding-inline-end: 0.325em;
        }
        &::after {
          content: "This notice is unimportant and can be dismissed."
        }
      }

      /* endregion */
      /* ====================================== */

      /* ====================================== */
      /* region Discorage clicking on trackers: */

      #astra-dashboard-app a[href*="utm_source=free-theme"],
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
    add_action('customize_controls_enqueue_scripts', [ $this, 'admin_ad_disable_css' ], PHP_INT_MAX);
  }
}

new Admin_Ad_Sanitizer();

// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#region Overrides

if ( Admin_Ad_Sanitizer::is_plugin_active('themehunk-megamenu-plus/themehunk-megamenu.php') ) {
  class ThemeHunk_Notify {
    // this class is here to disable an obnoxious slider advertisement.
    public function __construct() {
      // if ( !isset($_COOKIE['thc_time']) ) {
      // This cookie helps prevent the obnoxious banner from loading:
      //        setcookie('thc_time', time() + ( 86457 * 30 ), PHP_INT_MAX);
      // }
      foreach ( [ 'owl.carousel', 'hunk-companion-notice' ] as $remove ) {
        // Attempt to remove any assets used by the obnoxious banner:
        wp_dequeue_style($remove);
        wp_deregister_style($remove);
      }
      foreach ( [ 'owl.carousel', 'hunk-companion-notify' ] as $remove ) {
        // Attempt to remove any assets used by the obnoxious banner:
        wp_dequeue_script($remove);
        wp_deregister_script($remove);
      }
      foreach ( [
        [ 'hook' => 'admin_init', 'method' => 'set_cookie' ],
        [ 'hook' => 'admin_notices', 'method' => 'notify' ],
        [ 'hook' => 'admin_enqueue_scripts', 'method' => 'enqueue' ],
        [ 'hook' => 'admin_notices', 'method' => 'unset_cookie' ],
      ] as $values ) {
        // Attempt to remove any assets used by the obnoxious banner:
        remove_action($values['hook'], [ $this, $values['method'] ]);
      }
    }
  }

  new ThemeHunk_Notify();
}

#endregion Overrides
