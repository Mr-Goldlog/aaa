function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'ru',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        multilanguagePage: true,
        gaTrack: true,
        gaId: 'UA-56330431-1'
    }, 'google_translate_element');
}