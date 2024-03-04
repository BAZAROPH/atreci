"use strict";
AUI().ready('aui-ace-editor', function(A) {
    var editor = new A.AceEditor({
        boundingBox: '#editor',

        // highlightActiveLine: false,
        // readOnly: true,
        // tabSize: 8,
        // useSoftTabs: true,
        // useWrapMode: true,
        // showPrintMargin: false,
        mode: 'sql',
        //value: ""
    }).render();
    var textarea = $('textarea[name="requete"]');
    editor.getSession().on("change", function() {
        textarea.val(editor.getSession().getValue());
    });
    editor.getEditor().setTheme('ace/theme/monokai');

    //editor.set('mode', 'javascript');
    // editor.set('mode', 'json');
    // editor.set('mode', 'xml');

    var mode = A.one('#mode');
    if (mode) {

        var currentMode = 'sql';

        mode.on('change', function(event) {
            currentMode = this.val();

            editor.set('mode', currentMode);


        });
    }

    // editor.set('value', 'Change the original content');
});