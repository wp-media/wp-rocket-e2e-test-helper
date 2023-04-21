<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="container-fluid py-4 wpr-e2e-container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php foreach ( $this->views as $view ) : ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $view === current( $this->views ) ? 'active' : ''; ?>" id="<?php echo esc_attr( $view['id'] ); ?>_tab" data-bs-toggle="tab" data-bs-target="#<?php echo esc_attr( $view['pane'] ); ?>" type="button" role="tab" aria-controls="<?php echo esc_attr( $view['pane'] ); ?>" aria-selected="<?php echo $view === current( $this->views ) ? 'true' : 'false'; ?>"><?php echo esc_html( $view['name'] ); ?></button>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content py-4" id="myTabContent">