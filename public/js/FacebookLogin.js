            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId={{ env('FB_APPID') }}";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            function fbLogin() {
                FB.login(function (response) {
                    if (response.status==='connected') {
                        FB.api('/me',{fields: 'name'}, function (response) {
                            $.ajax({
                                type: "POST",
                                url: "/user",
                                dataType: "text",
                                headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                                data: {social: 'facebook', id:response.id, name:response.name},
                                success: function(result) {
                                    console.log(result);
                                    location.reload();
                                },
                                error: function(textStatus, errorThrown) {
                                    console.log('error');
                                    console.log(textStatus);
                                    console.log(errorThrown);
                                }
                            });
                        });
                    }
                }, {scope:'public_profile'});
            }