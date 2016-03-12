$(function(){
    $('.pupup-search').live('click',function(){
        var self = $(this);
        var win = window.open(base_path+'admin/'+self.attr('data-popup')+'/searchPopup');
        $(win.document).ready(function(){
            win.selectCallBack = function(val){
                self.parent().find('input').val(val);
            };
        });
    });

    $('.selectInPopupButton').live('click',function(){
        var self = $(this);
        var id = self.parents('tr:first').find('td:first').text();
        selectCallBack(id);
        window.close();
    });
});