grecaptcha.ready(function () {
    grecaptcha.execute('6LcSg74UAAAAAITWhv6uGUYeh_KsjIOCUuJzYRCZ', {action: 'homepage'}).then(function (token) {
        document.getElementById("token").value = token;
    });
});
