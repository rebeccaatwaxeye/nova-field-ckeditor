<script>
export default {
    props: {
        title: {type: String, default: null},
        modelValue: {type: Boolean, default: false},
        scrollLock: {type: Boolean, default: true},
        fullscreen: {type: Boolean, default: false},
    },
    watch: {
        modelValue: {
            immediate: true,
            handler(value) {
                if (value) {
                    if (this.scrollLock) {
                        document.documentElement.classList.add('modal-open')
                    }
                    document.addEventListener('keydown', this.onKeyDownEsc)
                } else {
                    if (this.scrollLock) {
                        document.documentElement.classList.remove('modal-open')
                    }
                    document.removeEventListener('keydown', this.onKeyDownEsc)
                }
            }
        },
    },
    methods: {
        onKeyDownEsc(event) {
            if (event.key === "Escape") {
                this.$emit('update:modelValue', false)
            }
        },
        hasSlot(slot) {
            return !!this.$slots[ slot ]
        }
    }
}
</script>
<template>
    <transition mode="out-in" name="editorModal">
        <div v-if="modelValue"
             class="flex fixed inset-0 py-24 z-50 items-center bg-gray-500 bg-opacity-75 transition-opacity media-modal"
             role="dialog">
            <div :class="fullscreen ? 'w-screen h-screen' :  'max-w-2xl w-full h-full max-h-1/2 mx-auto'"
                 class="flex flex-col bg-white rounded shadow dark:bg-gray-800 dark:border-2 dark:border-gray-700">
                <div class="flex items-center p-4 border-b flex-0">
                    <div v-if="title"
                         class="flex items-center pl-2 h-14 flex-0">
                        <h3 class="self-center text-gray-400">{{ title }}</h3>
                    </div>
                    <div class="flex-1 items-center px-1">
                        <slot name="header"></slot>
                    </div>
                    <div :class="{'pr-2': title}" class="flex items-center flex-0">
                        <button class="m-0 w-8 h-8 text-gray-800 dark:text-white cursor-pointer"
                                @click.prevent="this.$emit('update:modelValue', false)">
                            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"
                                    fill="currentColor" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex-1 w-full h-full bg-grad-sidebar overflow-y-scroll">
                    <slot name="default"></slot>
                </div>
                <div v-if="hasSlot('footer')" class="p-2 w-full border-t flex-0 bg-logo">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </transition>
</template>
<style lang="sass">
.editorModal-enter-active,
.editorModal-leave-active
    transition: all 120ms ease-in-out !important

.editorModal-enter, .editorModal-leave-to
    opacity: 0 !important
    transform: scale(1.1) !important

html.modal-open,
html.modal-open body
    overflow: hidden !important

.max-h-1\/2
    max-height: 50vh

.bg-opacity-75
    --tw-bg-opacity: 0.75
</style>
