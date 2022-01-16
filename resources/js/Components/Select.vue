<template>
  <select
    class="form-select appearance-none
      block
      w-full
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      transition
      ease-in-out
      mt-1
      mx-0
      border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    ref="select"
  >
    <option
      v-for="option in options"
      :key="option.val"
      :value="option.val"
    >
      {{ option.text }}
    </option>
  </select>
</template>

<script>

export default {
  emits: ['update:modelValue'],
  methods: {
    focus () {
      this.$refs.select.focus()
    }
  },
  props: {
    modelValue: {},
    options: {
      type: Array,
      required: true
    }
  }
}
</script>