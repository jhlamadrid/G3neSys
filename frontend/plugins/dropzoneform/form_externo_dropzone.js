
var FormDropzone = function () {
    var movimientos;

    return {
        //main function to initiate the module
        setMovimientos: function (data) {
            movimientos = data;
        },
        init: function () {
            Dropzone.options.myDropzone = {
                autoProcessQueue: false, // Impide la subida automatica
                maxFiles: 5,
                maxFilesize: 25,
                dictDefaultMessage: "ARRASTRE LOS ARCHIVOS O HAGA CLICK PARA SUBIRLOS ",
                acceptedFiles: "application/pdf,\n\
                                image/*,\n\
                                application/vnd.ms-excel,\n\
                                text/plain,\n\
                                application/msword,\n\
                                application/zip,.zip,.rar,\n\
                                application/rar,\n\
                               ",
                /*acceptedFiles: "image/*,\n\
                                application/vnd.ms-excel,\n\
                                application/vnd.openxmlformats-officedocument.wordprocessingml.document,\n\
                                application/docx,\n\
                                application/pdf,\n\
                                application/ppt,\n\
                                application/pptx,\n\
                                text/plain,\n\
                                application/msword,\n\
                                application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", */
                init: function () {
                    this.on("addedfile", function (file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remover</a>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function (e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeAllFiles();
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                    this.on("error", function (file) {
                        if (!file.accepted) {

                            this.removeFile(file);
                        }
                    });
                    this.on('sending', function (file, xhr, formData) {
                        formData.append('idDocumento', movimientos);
                    });

                    this.on("success", function(file, responseText) {
                        //console.log(responseText);
                        var data = jQuery.parseJSON( responseText);
                        this.removeAllFiles();
                        ruta_archivo = data.ruta; 
                        //Alerta(data.title, data.message, data.code);
                        
                        //console.log(data.ruta);
                    });
                },
                success: function (file, data) {
                    
                }
            }
        }
    };
}();

jQuery(document).ready(function () {
    FormDropzone.init();
});