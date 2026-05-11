(function () {
    tinymce.PluginManager.add('quicktextinsert', function (editor) {
        var snippets = window.qtiSnippets || [];

        if (!snippets.length) {
            return;
        }

        var items = snippets.map(function (snippet, index) {
            return {
                text: snippet.name,
                onclick: function () {
                    editor.insertContent(snippet.text);
                }
            };
        });

        editor.addButton('quicktextinsert', {
            icon: 'paste',
            type: 'splitbutton',
            title: 'Insert Quick Text',
            menu: items,
            onclick: function () {
                editor.insertContent(items[0] ? snippets[0].text : '');
            }
        });
    });
})();
