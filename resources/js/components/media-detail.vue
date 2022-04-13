<script>
import IndexView from './media-index'

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    extends: IndexView,
}
</script>
<template>
    <panel-item :field="field">
        <template slot="value">
            <v-lazy-image
                v-if="preview"
                :src="preview"
                :src-placeholder="$options.spinner"
                :style="{
                    width: 'auto',
                    height: 'auto',
                    maxWidth: `${field.defail_width}px`,
                    maxHeight: `${field.defail_height}px`
                }"
                class="shadow-md rounded m-2 block"
            />
        </template>
    </panel-item>
</template>

