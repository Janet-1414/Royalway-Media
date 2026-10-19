{{-- Cookie Consent & Third-Party Tools --}}
<script>
function loadThirdPartyTools() {
    @if(env('CLARITY_ID'))
    // Microsoft Clarity
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window,document,"clarity","script","{{ env('CLARITY_ID') }}");
    @endif

    @if(env('META_PIXEL_ID'))
    // Meta Pixel
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ env('META_PIXEL_ID') }}');
    fbq('track', 'PageView');
    @endif
}

// Auto-load if consent already given
if (localStorage.getItem('cookie_consent') === 'accepted') {
    loadThirdPartyTools();
}
</script>
