var elfinderConnectorUrl;// define in php
function baseElfinder() {
    var elf = $('#elfinder').elfinder({
        url:elfinderConnectorUrl,
        lang:'ru',
        title:'Файлы',
        resizable:false,
        height:500,

    }).elfinder('instance');
}

var editor_dialog;
function editorElfinder(callback) {
    if (!editor_dialog) {
        editor_dialog = $('<div />').dialogelfinder(
            {
                lang:'ru',
                title:'Файлы',
                url:elfinderConnectorUrl,
                commandsOptions:{
                    getfile:{ oncomplete:'close'  }
                },
                getFileCallback:callback,
            });
    }
    else {
        editor_dialog.dialogelfinder('open');
    }
}


function openElfinder(input, img_block) {
    $('<div />').dialogelfinder({
        lang:'ru',
        title:'Файлы',
        url:elfinderConnectorUrl,
        commandsOptions:{
            getfile:{ oncomplete:'destroy', onlyURL:false  }
        },
        getFileCallback:function (data) {
            $('#' + input).val(data['url'] + '~' + data['tmb']);
            $('#' + img_block).attr('src', data['url']);
        },
    });
}

function openElfinderSingle(callback) {
    $('<div />').dialogelfinder({
        lang:'ru',
        title:'Файлы',
        url:elfinderConnectorUrl,
        commandsOptions:{
            getfile:{ oncomplete:'destroy', onlyURL:false  }
        },
        getFileCallback:callback,
    });
}
function openElfinderMulti(callback) {
    $('<div />').dialogelfinder({
        lang:'ru',
        title:'Файлы',
        url:elfinderConnectorUrl,
        commandsOptions:{
            getfile:{ onlyURL:false  }
        },
        getFileCallback:callback,
    });
}
