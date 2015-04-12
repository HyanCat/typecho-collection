<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div><!-- end .row -->
    </div>
    <footer id="footer" role="contentinfo">
    <div class="link">
      <ul>
        <?php Links_Plugin::output('SHOW_MIX'); ?>
      </ul>
    </div>
   <div class="copy">
      &copy; <?php echo date('Y', time()); ?> <a href="<?php $this->options->siteurl(); ?>"> <?php $this->options->title(); ?> </a> - 
      本站所有文章版权归<a href="" rel="nofollow"> <?php $this->options->title(); ?> </a>所有 - 
      未经许可禁止一切转载！<a href=""></a>
  </div>
    <?php _e('由 <a href="http://developer.baidu.com">BAE</a> 强力驱动'); ?>.
    <script type="text/javascript" src="<?php $this->options->themeUrl('lib/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('lib/lazyload.js'); ?>"></script>
    <?php $this->footer(); ?>
    <script type="text/javascript">
      $(function(){
        $("img").not(".thumb").lazyload({
          placeholder:"<?php $this->options->themeUrl('img/placeholder.gif'); ?>",
          effect:"fadeIn"
        });
      });
    </script>
</footer><!-- end #footer -->
</div><!-- end #body -->




</body>
</html>
