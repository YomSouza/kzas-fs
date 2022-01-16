<template>
  <form @submit.prevent="search">
    <slot />
    <div class="flex items-center justify-end space-x-2">
      <BreezeButton
        type="submit"
        class="rounded-full"
        title="Buscar"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          />
        </svg>
      </BreezeButton>
      <BreezeButton
        type="reset"
        @click.prevent="reset"
        class="rounded-full"
        title="Limpar filtros"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </BreezeButton>
    </div>
  </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'

export default {
  components: {
    BreezeButton
  },
  methods: {
    reset () {
      this.$emit('reset')
    },
    search () {
      this.$emit('search')
    }
  }
}
</script>