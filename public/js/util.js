/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// JavaScript Document

$(function() {

    $('table.tab_itens tbody tr').mouseover(function() {
        $(this).addClass('selectedRowAta');
    }).mouseout(function() {
        $(this).removeClass('selectedRowAta');
    })

    //Portlet Icon Toggle
    $(".panel-heading .fa-chevron-down, .panel-heading .fa-chevron-up, #btnEdit").click(function() {
        $(".panel-heading .fa-chevron-down, .panel-heading .fa-chevron-up").toggleClass("fa-chevron-down fa-chevron-up");
    });
    
    $("#btnEdit").click(function() {
        
    });
    
    $("#id_policial").select2();
    
    $(".dataPicker").datepicker();


});

function abrirModalVitima() {
    $("#modalVitima").dialog("open");
}



function resetForm(id) {
    $('#' + id).each(function() {
        this.reset();
    });
}


// increase the default animation speed to exaggerate the effect
$.fx.speeds._default = 1000;
$(function() {
    $("#modalVitima").dialog({
        autoOpen: false,
        show: "fade",
        hide: "fade",
        modal: true,
        resizable: false,
        height: 500,
        width: 1000,
        position: { my: "center", at: "center", of: '#page-wrapper' },
        close: function() {
            //resetForm('formCurso');
        },
        buttons: {
            //"Salvar": function() {
            //addCurso();
            //},
            Fechar: function() {
                $(this).dialog("close");
            }
        }
    });


});


function loadPermissoes(idu, itu) {
    $.ajax({
        type: 'post',
        url: 'ctrl_permissoes.php',
        data: {
            idu: idu,
            itu: itu
        },
        beforeSend: function() {
        },
        success: function(data) {

            $('#janelaPermissoes').html(data);
            $("#modulos").accordion({
                heightStyle: "content"
            });

            $('input:checkbox').each(function() {
                var self = $(this),
                        label = self.next(),
                        label_text = label.text();

                label.remove();
                self.iCheck({
                    checkboxClass: 'icheckbox_line-green',
                    insert: '<div class="icheck_line-icon"></div>' + label_text
                });
            });

            $('input:checkbox').on('ifChanged', function(event) {
                //alert($(this).attr('dado1') + ' callback');
                var valor = 0;
                var ele = $(this);
                if ($(this).attr('checked') == "checked")
                    valor = 1;

                $.ajax({
                    type: 'post',
                    url: 'mudar_permissao.php',
                    data: {
                        idu: $(this).attr('dado1'),
                        id_sub_mod: $(this).attr('dado2'),
                        acao: $(this).attr('dado3'),
                        valor: valor,
                    },
                    success: function(p) {
                        if (p == "0")
                            alert("Erro na Permissão.");
                        if (p == "-1") {
                            alert("Usuário sem mudança de Permissão.");
                        }


                    },
                    error: function(erro) {
                        alert("Aconteceu algum erro na Requisição.");
                    }
                });
            });


        },
        error: function(erro) {
            alert("Aconteceu algum erro na Requisição.");
        }
    });
}

