        $(document).ready(function() {
            /*
             *  Simple image gallery. Uses default settings
             */

            $('.fancybox').fancybox();


            /*
             *  Open manually
             */

            $("#fancybox-manual-a").click(function() {
                $.fancybox.open('1_b.jpg');
            });

            $("#fancybox-manual-b").click(function() {
                $.fancybox.open({
                    href : 'iframe.html',
                    type : 'iframe',
                    padding : 5
                });
            });

            $("#fancybox-manual-c").click(function() {
                $.fancybox.open([
                    {
                        href : '1_b.jpg',
                        title : 'My title'
                    }, {
                        href : '2_b.jpg',
                        title : '2nd title'
                    }, {
                        href : '3_b.jpg'
                    }
                ], {
                    helpers : {
                        thumbs : {
                            width: 75,
                            height: 50
                        }
                    }
                });
            });


        });
           $('#divieto_autocarri_2000 a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#disabili_giunta-c a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#disabili_giunta-P a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#bus_extraurbani a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#carico_scarico a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#cs2 a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#dossi a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#farmacia a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#piste_ciclabili a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
           $('#sensi_unici a').click(function (e) {
        e.defaultPrevented()
        $(this).tab('show')
})
