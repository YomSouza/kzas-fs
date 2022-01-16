<template>

  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Usuários
      </h2>
    </template>

    <Table :columns="['Nome', 'Email', 'Acesso ao dashboard']">
      <tr
        v-for="user in users"
        :key="user.id"
      >
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="text-sm font-medium text-gray-900">
            {{ user.name }}
          </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="text-sm text-gray-900">{{ user.email }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          <button
            @click.prevent="toggle(user)"
            :class="[user.has_dashboard_access ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ]"
            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
          >
            {{ user.has_dashboard_access ? 'Sim' : 'Não' }}
          </button>
        </td>
      </tr>
    </Table>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3'
import Table from '@/Components/Table.vue'
import { put } from '@/http'

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Table,
  },
  methods: {
    toggle (user) {
      put(route('users.toggle-dashboard-access', { id: user.id }))
        .then(({ has_dashboard_access }) => user.has_dashboard_access = has_dashboard_access)
    }
  },
  props: {
    users: Array
  }
}
</script>

<style>
</style>