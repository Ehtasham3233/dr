    <script id="dsq-count-scr" src="//dramacool-ukph88jvsw.disqus.com/count.js" async></script>

    <script type="text/javascript" src="{{ asset('frontend/js/jquery.min096a.js?v=4.7') }}"></script>
    <script type="text/javascript" src=" {{ asset('frontend/js/jquery-ui.min096a.js?v=4.7') }}"></script>
    <script type="text/javascript" src=" {{ asset('frontend/plugins/lazyload/lazyload.min096a.js?v=4.7') }}"></script>
    <script type="text/javascript" src=" {{ asset('frontend/js/main096a.js?v=4.7') }}"></script>
	<script type="text/javascript" src=" {{ asset('frontend/js/detectmobilebrowser.js') }}"></script>



<!-- <script src="{{ asset('all.js') }}"></script> -->

<!-- Stack array for including inline js or scripts -->
@stack('script')



<script type="text/javascript">
    var disqus_shortname = "dramacool-ukph88jvsw";
    $(window).on('load', function () {
      (function () {
        var dsq = document.createElement("script");
        dsq.type = "text/javascript";
        dsq.async = true;
        dsq.src = "https://" + disqus_shortname + ".disqus.com/embed.js";
        (document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);

        var dsqcount = document.createElement("script");
        dsqcount.type = "text/javascript";
        dsqcount.async = true;
        dsqcount.src = "https://" + disqus_shortname + ".disqus.com/count.js?";
        dsqcount.id = 'dsq-count-scr', (document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsqcount);
      })();
    });

    $(".closeadv2").click(function () {
      console.log('click');
      $(".loadservermp42").remove();
    });


        </script>
<!-- <script src="{{ asset('dist/js/theme.js') }}"></script>
<script src="{{ asset('js/chat.js') }}"></script> -->
