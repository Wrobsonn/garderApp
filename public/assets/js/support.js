const support = {
    init: function() {
       $(document).on('click' , '#view_form', function (){
           support.viewForm();
       });
    },
    viewForm: function() {
        const formView = document.getElementById('support_form');

        if (formView.classList.contains('d-none')) {
            formView.classList.remove('d-none');
        } else {
            formView.classList.add('d-none');
        }
    }
}
support.init();