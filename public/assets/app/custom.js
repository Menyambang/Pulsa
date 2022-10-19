/**
 * btnConfig
 * @param {string} btn
 * @param {obejct} setting
 * @param {obejct} attr
 *
 * attr => object {
 *    'key1' : 'value1',
 *    'key2' : 'value2',
 * }
 *
 * setting :
 * @param {bool} isIcon
 * @param {bool} isText
 * @param {bool} isTooltip
 * @param {string} textView
 *
 * @return void
 */
function btnDatatableConfig(btn, attr = [], setting = []) {
    $('[data-toggle="tooltip"]').tooltip();

    let isText = setting.hasOwnProperty("isText") ? setting.isText : false;
    let isIcon = setting.hasOwnProperty("isIcon") ? setting.isIcon : true;
    let isTooltip = setting.hasOwnProperty("isTooltip") ?
        setting.isTooltip :
        true;
    let disabled = setting.hasOwnProperty("disabled") ? setting.disabled : false;
    let show = setting.hasOwnProperty("show") ? setting.show : false;

    attrString = "";
    for (var a in attr) {
        if (a != "class") {
            attrString += a + "=" + attr[a] + " ";
        }
    }

    switch (btn) {
        case "detail":
            iconBtn = "feather icon-search";
            classBtn = "btn-outline-primary";
            textBtn = setting.hasOwnProperty("textBtn") ? setting.textBtn : "Detail";
            break;
        case "update":
            iconBtn = "feather icon-edit";
            classBtn = "btn-outline-warning";
            textBtn = setting.hasOwnProperty("textBtn") ? setting.textBtn : "Ubah";
            break;
        case "delete":
            iconBtn = "feather icon-trash";
            classBtn = "btn-outline-danger";
            textBtn = setting.hasOwnProperty("textBtn") ? setting.textBtn : "Hapus";
            break;
        case "custom":
            iconBtn = setting.hasOwnProperty("iconBtn") ? setting.iconBtn : 'feather icon-circle';
            classBtn = `btn-outline-${setting.hasOwnProperty("classBtn") ? setting.classBtn : 'primary'}`;
            textBtn = setting.hasOwnProperty("textBtn") ? setting.textBtn : "Detail";
            break;
        default:
            iconBtn = "";
            classBtn = "";
            textBtn = "";
            break;
    }

    let clientView = "";
    if (isText && isIcon) {
        clientView = `<i class='${iconBtn}'></i> ${textBtn}`;
    } else if (isText) {
        clientView = textBtn;
    } else if (isIcon) {
        clientView = `<i class='${iconBtn}'></i>`;
    }

    let clientTooltip = "";
    if (isTooltip) {
        clientTooltip = `data-container="body" data-toggle="tooltip" data-placement="top" data-original-title='${textBtn}'`;
    }

    if (disabled) {
        disabled = "disabled";
        classBtn = "btn-outline-secondary";
    }

    if (show) {
        return `<button style="margin:1px" ${disabled} class="btn btn-xs ${classBtn} waves-effect waves-light" ${clientTooltip} ${attrString}>${clientView}</button>`;
    }
    return '';

}

/**
 * dateConvertToIndo
 *
 * Mengubah tanggal SQL ke Format Indo
 *
 * @param {string} date
 * @param {obejct} option
 */
function dateConvertToIndo(date, option = []) {
    let isDay = option.hasOwnProperty("isDay") ? option.isDay : true;
    let isMonth = option.hasOwnProperty("isMonth") ? option.isMonth : true;
    let separator = option.hasOwnProperty("separator") ? option.separator : "";

    let time12 = new moment(date).format("hh:mm a");
    let time24 = new moment(date).format("HH:mm");
    let second = new moment(date).format(" ss");

    let monthName = isMonth ? "MMMM" : "MM";
    let dayDate = isDay ? "dddd, DD " : "DD ";

    date = new moment(date).locale("id").format(`${dayDate}${monthName} YYYY`);

    if (separator != "") {
        date = date.replace(/ /g, separator);
        date = date.replace("," + separator, ", ");
    }

    return {
        date: date,
        datetime12: date + " " + time12.toUpperCase(),
        datetime24: date + " " + time24.toUpperCase(),
        datetime24_s: date + " " + time24.toUpperCase() + second,
        datetime12: date + " " + time12.toUpperCase(),
        datetime12_s: date + " " + time12.toUpperCase() + second,
        time24: time24.toUpperCase(),
        time24_s: time24.toUpperCase(),
        time12: time12.toUpperCase(),
        time12_s: time12.toUpperCase() + second,
    };
}

/**
 * select2config
 *
 * membuat inputan menjadi select2
 *
 * @param {string} selector
 * @param {string} placeholder
 * @param {string} data
 * @param {string} selected
 */
function select2config(selector, placeholder = "", data = "", selected = "") {
    if ($(`.${selector}`).data("select2")) {
        $(`.${selector}`).select2("destroy");
    }

    if (data) {
        $(`.${selector}`).html(data);
    }

    $(`.${selector}`)
        .select2({
            placeholder: placeholder ?
                `-- Pilih ${placeholder} --` : `-- Pilih Data --`,
            width: "100%",
        });

    if (selected) {
        $(`.${selector}`).val(selected).trigger("change");
    }
}

/**
 * krajeeConfig
 *
 * @param {string} selector
 * @param {object} data
 *
 * data :
 * @param {string} url (https://google.com/file_foto.jpg)
 * jika ada file yang ingin ditampilkan di fileinput
 *
 * @param {string} filename (file_foto.jpg)
 * wajib jika ada url, untuk menentukan icon
 *
 * @param {string} caption (File Foto)
 * wajib jika ada url, untuk menampilkan label
 *
 * @param {string} type (pdf, image)
 * Menentukan validasi fileinput
 *
 * @param {bool} isUpload
 * Jika ingin upload langsung lewat file input
 *
 * @param {bool} isDrop
 * Jika ingin menampilkan dropzone
 *
 * @return void
 */
function krajeeConfig(selector, data = []) {
    let configInit = {
        language: "id",
        theme: "fa",
        rtl: true,
        // autoOrientImage: false,
        reversePreviewOrder: true,
        initialPreviewAsData: true,
        // autoReplace: true,
        maxFileCount: 20,
        maxImageWidth: 200,
        resizeImage: true,
        initialPreviewFileType: "image",
        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
        previewFileIconSettings: {
            // configure your icon file extensions
            pdf: '<i class="fa fa-file-pdf-o text-danger"></i>',
            doc: '<i class="fa fa-file-word-o text-danger"></i>',
            // docx : '<i class="fa fa-file-word-o text-danger"></i>',
            jpg: '<i class="fa fa-file-image-o text-danger"></i>',
            gif: '<i class="fa fa-file-image-o text-muted"></i>',
            png: '<i class="fa fa-file-image-o text-primary"></i>',
        },
    };
    let configActionTrue = {};
    let configActionFalse = {};
    let configView = {};
    let configType = {};
    let configUpload = {};
    let configDrop = {};
    let configButton = {};
    let configPreview = {};
    let configLabel = {};
    let configIcon = {};
    let configButtonClass = {};

    let url = data.hasOwnProperty("url") ? data.url : false;
    let filename = data.hasOwnProperty("filename") ? data.filename : false;
    let caption = data.hasOwnProperty("caption") ? data.caption : "Berkas";
    let action = data.hasOwnProperty("action") ? data.action : true;
    let type = data.hasOwnProperty("type") ? data.type : "pdf";
    let isUpload = data.hasOwnProperty("isUpload") ? data.isUpload : false;
    let isDrop = data.hasOwnProperty("isDrop") ? data.isDrop : false;
    let isButtonOnly = data.hasOwnProperty("isButtonOnly") ? data.isButtonOnly : false;
    let showPreview = data.hasOwnProperty("showPreview") ? data.showPreview : true;
    let label = data.hasOwnProperty("label") ? data.label : "";
    let icon = data.hasOwnProperty("icon") ? data.icon : "";
    let buttonClass = data.hasOwnProperty("buttonClass") ? data.buttonClass : "";

    // jika ingin melihat preview file
    if (showPreview) {
        configPreview = {
            showPreview: true,
        }
    }
    // jika ingin tidak ingin melihat preview file
    else {
        configPreview = {
            showPreview: false,
        }
    }

    // Jika yg diupload hanya foto
    if (type == "image") {
        configType = {
            allowedPreviewMimeTypes: ["image/jpeg", "image/jpg", "image/png"],
            allowedFileExtensions: ["jpg", "jpeg", "png"],
        };
    }
    // Jika yg diupload hanya pdf
    else if (type == "pdf") {
        configType = {
            allowedPreviewMimeTypes: ["pdf"],
            allowedFileExtensions: ["pdf"],
        };
    }
    // Jika yg diupload foto/pdf
    else if (type == "image/pdf") {
        configType = {
            allowedPreviewMimeTypes: ["image/jpeg", "image/jpg", "image/png", "pdf"],
            allowedFileExtensions: ["jpg", "jpeg", "png", "pdf"],
        };
    }
    // jika yg diupload excel
    else if (type == 'excel') {
        configType = {
            allowedPreviewMimeTypes: ["application/excel"],
            allowedFileExtensions: ["xlsx", "xls"],
        };
    }

    // jika ingin menampilkan file
    if (url) {
        configView = {
            initialPreview: [url],
            initialPreviewConfig: [{
                type: type,
                caption: caption,
                filename: filename,
                downloadUrl: false,
            }, ],
            initialPreviewShowDelete: false,
        };
    }

    if (label != '') {
        configLabel = {
            browseLabel: label,
        }
    }

    if (icon != '') {
        configIcon = {
            browseIcon: `<i class="${icon}"></i>&nbsp;`,
        }
    }

    if (buttonClass != '') {
        configButtonClass = {
            browseClass: buttonClass,
        }
    }

    // jika fileinput hanya button saja
    if (isButtonOnly) {
        configButton = {
            showCaption: false,
            showRemove: false,
            showUpload: false,
            showPreview: false,
        }
    } else {
        // jika ingin menampilkan aksi browse, delete
        if (action) {
            configActionTrue = {
                actionDelete: true,
                showPreview: true,
                showCaption: true,
                showRemove: true,
                overwriteInitial: true,
            };
        }
        // jika hanya ingin melihat saja
        else {
            configActionFalse = {
                actionDelete: false,
                showRemove: false,
                showBrowse: false,
                showCaption: false,
                overwriteInitial: false,
            };
        }
    }

    // memunculkan button upload
    if (isUpload) {
        configUpload = {
            showUpload: true,
        };
    }
    // menyembunyikan button upload
    else {
        configUpload = {
            showUpload: false,
        };
    }

    // jika boleh drag & drop
    if (isDrop) {
        configDrop = {
            dropZoneEnabled: true,
        };
    }
    // jika tidak ada drag & drop
    else {
        configDrop = {
            dropZoneEnabled: false,
        };
    }

    config = Object.assign({},
        configType,
        configView,
        configActionTrue,
        configActionFalse,
        configUpload,
        configDrop,
        configInit,
        configButton,
        configPreview,
        configLabel,
        configIcon,
        configButtonClass,
    );

    $(selector).fileinput("clear").fileinput("destroy").fileinput(config);
}