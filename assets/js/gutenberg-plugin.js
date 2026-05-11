(function (wp) {
    var snippets = (typeof qtiSnippets !== 'undefined') ? qtiSnippets : (window.qtiSnippets || []);

    if (!snippets.length) {
        return;
    }

    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var __ = wp.i18n.__;

    snippets.forEach(function (snippet) {
        if (!snippet || !snippet.name || !snippet.text || !snippet.slug) {
            return;
        }

        var blockName = 'quick-text-insert/' + snippet.slug;

        registerBlockType(blockName, {
            apiVersion: 3,
            title: snippet.name,
            description: __('Quick text snippet.'),
            icon: 'editor-paste-text',
            category: 'widgets',
            supports: {
                html: false,
                customClassName: false
            },
            attributes: {
                content: {
                    type: 'string',
                    default: snippet.text
                }
            },
            edit: function (props) {
                var content = props.attributes.content;
                var setAttrs = props.setAttributes;

                return el('textarea', {
                    value: content,
                    onChange: function (e) {
                        setAttrs({ content: e.target.value });
                    },
                    style: {
                        width: '100%',
                        minHeight: '100px',
                        padding: '12px',
                        fontFamily: 'monospace',
                        fontSize: '13px',
                        lineHeight: '1.5',
                        border: '1px solid #dcdcde',
                        borderRadius: '4px',
                        background: '#f6f7f7',
                        color: '#1d2327',
                        resize: 'vertical',
                        boxSizing: 'border-box'
                    }
                });
            },
            save: function () {
                return null;
            }
        });
    });
})(window.wp);
