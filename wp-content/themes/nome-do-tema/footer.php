<?php
/**
 * Footer template
 *
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after.
 *
 * @package Theme
 */

$path = get_template_directory_uri();
?>
    </div>

    <!-- FOOTER -->
    <?php include 'components/footer.php'; ?>

    <?php wp_footer(); ?>

    <script src="<?php echo $path; ?>/script.js?v=<?php echo filemtime(__DIR__ . '/script.js'); ?>"></script>

  </body>
</html>
