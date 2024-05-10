<?php
defined( 'ABSPATH' ) || exit;

settings_errors( CONFIG['PLUGIN_ID'] . '_response' );
require_once 'templates/header.php'; 

if ( ! is_wpr_active() ) :
?>
    <div class="container-fluid">
        <div class="alert alert-warning py-2" id="wpr_active_status">
        <small><strong>WP Rocket is currently not active. The E2E test helper plugin might not work correctly.</strong></small>
        </div>
    </div>
    <?php endif; foreach ( $this->views as $view ) : ?>
        <div class="tab-pane fade<?php echo $view === current( $this->views ) ? ' show active' : ''; ?>" id="<?php echo esc_attr( $view['pane'] ); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr( $view['id'] ); ?>_tab" tabindex="0">
            <div class="container-fluid py-2">
                <?php $this->template->load_view( $view['id'] ); ?>
            </div>
        </div>
    <?php endforeach ?>
<?php require_once 'templates/footer.php'; ?>