<template>
  <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
      <div class="flex flex-col items-center pt-8 sm:justify-start sm:pt-0">
        <div class="px-4 text-lg text-gray-500 uppercase tracking-wider">
          {{ title }}
        </div>
        <div class="text-md text-gray-500 tracking-wider">
          {{ description }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    status: Number,
  },
  computed: {
    title () {
      return {
        503: '503: Servidor em manutenção',
        500: '500: Servidor instável',
        404: '404: Recurso não encontrado',
        403: '403: Acesso negado',
      }[this.status]
    },
    description () {
      return {
        503: 'Desculpe, estamos em manutenção. Logo os serviços estarão restabelecidos.',
        500: 'Desculpe, nossos servidores estão passando por instabilidades.',
        404: 'Desculpe, a página não pode ser encontrada.',
        403: 'Desculpe, você não possui autorização para acessar esse recurso.',
      }[this.status]
    },
  },
}
</script>