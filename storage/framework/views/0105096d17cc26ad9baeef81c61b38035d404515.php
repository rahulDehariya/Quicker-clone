
<?php if(config('settings.single.wysiwyg_editor') == 'tinymce'): ?>
    <script src="<?php echo e(asset('assets/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <?php
    $editorI18n = \Lang::get('tinymce', [], config('app.locale'));
    $editorI18nJson = '';
    if (!empty($editorI18n)) {
        $editorI18nJson = collect($editorI18n)->toJson();
        // Convert UTF-8 HTML to ANSI
        $editorI18nJson = convertUTF8HtmlToAnsi($editorI18nJson);
    }
    ?>
    <script type="text/javascript">
        tinymce.init({
            selector: '#description',
            language: '<?php echo e((!empty($editorI18nJson)) ? config('app.locale') : 'en'); ?>',
            directionality: '<?php echo e((config('lang.direction') == 'rtl') ? 'rtl' : 'ltr'); ?>',
            height: 350,
            menubar: false,
            statusbar: false,
            plugins: 'lists link table',
            toolbar: 'undo redo | bold italic underline | forecolor backcolor | bullist numlist blockquote table | link unlink | alignleft aligncenter alignright | outdent indent | fontsizeselect',
        });
        <?php if(!empty($editorI18nJson)): ?>
            tinymce.addI18n('<?php echo e(config('app.locale')); ?>', <?php echo $editorI18nJson; ?>);
        <?php endif; ?>
    </script>
<?php endif; ?>


<?php if(config('settings.single.wysiwyg_editor') == 'ckeditor'): ?>
    <script src="<?php echo e(asset('assets/plugins/ckeditor/ckeditor.js')); ?>"></script>
    <?php
    $editorLocale = '';
    if (file_exists(public_path() . '/assets/plugins/ckeditor/translations/' . ietfLangTag(config('app.locale')) . '.js')) {
        $editorLocale = ietfLangTag(config('app.locale'));
    }
    if (empty($editorLocale)) {
        if (file_exists(public_path() . '/assets/plugins/ckeditor/translations/' . ietfLangTag(config('lang.locale')) . '.js')) {
            $editorLocale = ietfLangTag(config('lang.locale'));
        }
    }
    if (empty($editorLocale)) {
        if (file_exists(public_path() . '/assets/plugins/ckeditor/translations/' . strtolower(ietfLangTag(config('lang.locale'))) . '.js')) {
            $editorLocale = strtolower(ietfLangTag(config('lang.locale')));
        }
    }
    if (empty($editorLocale)) {
        $editorLocale = 'en';
    }
    ?>
    <?php if($editorLocale != 'en'): ?>
        <script src="<?php echo e(asset('assets/plugins/ckeditor/translations/' . $editorLocale . '.js')); ?>"></script>
    <?php endif; ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            ClassicEditor.create(document.querySelector('#description'), {
                language: '<?php echo e($editorLocale); ?>',
                toolbar: {
                    items: [
                        'undo',
                        'redo',
                        '|',
                        'bold',
                        'italic',
                        '|',
                        'fontColor',
                        'fontBackgroundColor',
                        '|',
                        'bulletedList',
                        'numberedList',
                        'blockQuote',
                        'alignment',
                        '|',
                        'insertTable',
                        'link',
                        '|',
                        'heading',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'removeFormat'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                }
            }).then( editor => {
                window.editor = editor;
            }).catch(error => {
                console.error('Oops, something gone wrong!');
                console.error('Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:');
                console.warn('Build id: v28nci2fjq9h-1yblopey8x43');
                console.error(error);
            });
        });
    </script>
<?php endif; ?>


<?php if(config('settings.single.wysiwyg_editor') == 'summernote'): ?>
    <script src="<?php echo e(asset('assets/plugins/summernote/summernote-bs4.min.js')); ?>"></script>
    <?php
    $editorLocale = '';
    if (file_exists(public_path() . '/assets/plugins/summernote/lang/summernote-' . ietfLangTag(config('app.locale')) . '.js')) {
        $editorLocale = ietfLangTag(config('app.locale'));
    }
    if (empty($editorLocale)) {
        if (file_exists(public_path() . '/assets/plugins/summernote/lang/summernote-' . ietfLangTag(config('lang.locale')) . '.js')) {
            $editorLocale = ietfLangTag(config('lang.locale'));
        }
    }
    if (empty($editorLocale)) {
        if (file_exists(public_path() . '/assets/plugins/summernote/lang/summernote-' . strtolower(ietfLangTag(config('lang.locale'))) . '.js')) {
            $editorLocale = strtolower(ietfLangTag(config('lang.locale')));
        }
    }
    if (empty($editorLocale)) {
        $editorLocale = 'en-US';
    }
    ?>
    <?php if($editorLocale != 'en-US'): ?>
        <script src="<?php echo e(url('assets/plugins/summernote/lang/summernote-' . $editorLocale . '.js')); ?>" type="text/javascript"></script>
    <?php endif; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#description').summernote({
                lang: '<?php echo e($editorLocale); ?>',
                placeholder: '<?php echo e(t('describe_what_makes_your_ad_unique')); ?>...',
                tabsize: 2,
                height: 350,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']]
                ]
            });
        });
    </script>
<?php endif; ?>


<?php if(config('settings.single.wysiwyg_editor') == 'simditor'): ?>
    <script src="<?php echo e(asset('assets/plugins/simditor/scripts/mobilecheck.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/simditor/scripts/module.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/simditor/scripts/hotkeys.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/simditor/scripts/dompurify.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/simditor/scripts/simditor.js')); ?>"></script>
    <?php
    $editorI18n = \Lang::get('simditor', [], config('app.locale'));
    $editorI18nJson = '';
    if (!empty($editorI18n)) {
        $editorI18nJson = collect($editorI18n)->toJson();
        // Convert UTF-8 HTML to ANSI
        $editorI18nJson = convertUTF8HtmlToAnsi($editorI18nJson);
    }
    ?>
    <script type="text/javascript">
        <?php if(!empty($editorI18nJson)): ?>
            Simditor.i18n = {'<?php echo e(config('app.locale')); ?>': <?php echo $editorI18nJson; ?>};
        <?php endif; ?>
        
        <?php /* Fake Code Separator */ ?>
        
        (function() {
            $(function() {
                <?php if(!empty($editorI18nJson)): ?>
                    Simditor.locale = '<?php echo e(config('app.locale')); ?>';
                <?php endif; ?>
                
                var $preview, editor, mobileToolbar, toolbar, allowedTags;
                
                toolbar = ['bold','italic','underline','|','fontScale','color','|','ul','ol','blockquote','|','table','link','|','alignment','indent','outdent'];
                mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
                if (mobilecheck()) {
                    toolbar = mobileToolbar;
                }
                allowedTags = ['br','span','a','img','b','strong','i','strike','u','font','p','ul','ol','li','blockquote','pre','h1','h2','h3','h4','hr','table'];
                
                /* Init */
                editor = new Simditor({
                    textarea: $('#description'),
                    placeholder: '<?php echo e(t('describe_what_makes_your_ad_unique')); ?>...',
                    toolbar: toolbar,
                    allowedTags: allowedTags,
                    defaultImage: '<?php echo e(asset('assets/plugins/simditor/images/image.png')); ?>',
                    pasteImage: false,
                    upload: false
                });
                
                $preview = $('#preview');
                if ($preview.length > 0) {
                    return editor.on('valuechanged', function(e) {
                        return $preview.html(editor.getValue());
                    });
                }
            });
        }).call(this);
    </script>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/resources/views/layouts/inc/tools/wysiwyg/js.blade.php ENDPATH**/ ?>