<script>
import CkEditor from '../ckeditor/ckeditor'
import SnippetBrowser from "./snippet-browser"
import MediaBrowser from "./media-browser"
import LinkBrowser from "./link-browser"
import HasUUID from "./mixins/HasUUID"
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import {toRaw} from 'vue';

export default {
    data() {
        return {
            value: this.field.value || '',
            _uuid: 0,
            editor: {}
        }
    },
    components: {SnippetBrowser, LinkBrowser, MediaBrowser},
    mixins: [FormField, HandlesValidationErrors, HasUUID],
    props: ['resourceName', 'resourceId', 'field', 'toolbar'],
    methods: {
        setInitialValue() {
            this.value = this.field.value || ''
        },
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },
        handleChange(value) {
            this.value = value
        },
        handleEditorEvents(event, data) {
            if (['Tab', '/'].includes(data.key) || [191, 9].includes(data.keyCode)) {
                data.stopPropagation()
            }
        },
        handleEditorSync() {
            this.handleChange(toRaw(this.editor).getData())
        },
    },
    created() {
        this.$options.uuid = this.uuid()
    },
    mounted() {
        this.setInitialValue()
        CkEditor.create(this.$refs.editor, {
            attribute: this.$options.uuid,
            linkBrowser: this.field.linkBrowser,
            mediaBrowser: this.field.mediaBrowser,
            snippetBrowser: this.field.snippetBrowser,
            toolbar: {items: this.field.toolbar, shouldNotGroupWhenFull: true},
            codeBlock: {languages: this.field.codeBlock}
        }).then((editor) => {
            const {editing, model} = this.editor = editor

            //Prevent QuestionMark & Slash from triggering Nova Search.
            editing.view.document.on('keydown', this.handleEditorEvents, {
                priority: 'highest'
            })
            //Sync Model Changes to VueModel.
            model.document.on('change', this.handleEditorSync, {
                priority: 'lowest'
            })
            // Set the height of the editor when editing.
            if (this.value && this.value.length > 1) {
                editor.ui.view.editable.element.style.height = `${this.field.height}px`;
            }
        })
            .catch((e) => this.$toasted.show(e.toString(), {type: 'error'}))
    },
    beforeDestroy() {
        if (this.editor) {
            this.editor
                .destroy()
                .then(() => this.editor = null)
                .catch((e) => this.$toasted.show(e.toString(), {type: 'error'}))
        }
    },
}
</script>
<template>
    <default-field :errors="errors" :field="field" :full-width-content="true">
        <template #field>
            <textarea
                :id="field.attribute"
                ref="editor"
                :class="errorClasses"
                :value="value"
                class="hidden"
                data-ref="editor"
            />
            <link-browser
                :field-key="$options.uuid"
            />
            <media-browser
                :field-key="$options.uuid"
                :multiple="true"
                @select="$options.editor.execute('mediaBrowser', $event)"
            />
            <snippet-browser
                :field-key="$options.uuid"
                :snippets="field.snippetBrowser"
            />
        </template>
    </default-field>
</template>
<style lang="sass">
.ck-content.ck-editor__editable
    resize: vertical

.ck.ck-reset.ck-editor
    .ck.ck-toolbar
        border-radius: 10px 10px 0 0

    .ck-editor__editable_inline
        border-radius: 0 0 10px 10px
        margin: 0
        padding: 0 10px
        @import "../../sass/field"

    .ck.ck-editor__editable:not(.ck-editor__nested-editable).ck-focused
        box-shadow: none

    .ck-editor__editable_inline
        min-height: 300px
</style>
