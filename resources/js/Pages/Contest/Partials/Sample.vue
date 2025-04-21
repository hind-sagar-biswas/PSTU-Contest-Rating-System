<script setup>
const str = '<span class="text-primary">"string"</span>';
const int = '<span class="text-secondary">int</span>';
</script>
<template>
    <pre data-prefix="1"><code>[</code></pre>
    <pre data-prefix="2"><code> {</code></pre>
    <pre data-prefix="3"><code> &nbsp;<span class="text-accent">"name"</span>: <i v-html="str"></i>,</code></pre>
    <pre data-prefix="4"><code> &nbsp;<span class="text-accent">"standing"</span>: <i v-html="int"></i>,</code></pre>
    <pre data-prefix="5"><code> &nbsp;<span class="text-accent">"solved"</span>: <i v-html="int"></i>,</code></pre>
    <pre data-prefix="6"><code> &nbsp;<span class="text-accent">"penalty"</span>: <i v-html="int"></i></code></pre>
    <pre data-prefix="7"><code> },</code></pre>
    <pre data-prefix="8"><code> ...</code></pre>
    <pre data-prefix="9"><code>]</code></pre>
</template>
