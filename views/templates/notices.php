<?php
defined( 'ABSPATH' ) || exit;

if ( ! isset( $data ) ) {
    return;
}
?>

<div class="notice notice-<?php echo esc_attr( $data['status'] ); ?>">
    <p id="<?php echo $data['id'] ?? esc_attr( $data['id'] ); ?>">
        <?php echo esc_html( $data['message'] ); ?>
    </p>
</div>