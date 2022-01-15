<template>

  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div
      v-if="!can_access"
      class="flex flex-col items-center"
    >
      <Forbidden title="Entre em contato com os admistradores para ter acesso aos recursos." />
    </div>
    <template v-else>
      <div class="flex flex-col mx-2 sm:mx-6">
        <Filters
          @search="getDevs(true)"
          @reset="resetSearch"
          class="space-y-4 "
        >
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
            <div class="p-2">
              <BreezeLabel
                for="name"
                value="Nome"
              />
              <BreezeInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="search.name"
                @keyup.enter="getDevs"
                autocomplete="name"
              />
            </div>
            <div class="col-sm-4 m-2">
              <BreezeLabel
                for="language"
                value="Linguagem"
              />
              <BreezeSelect
                id="language"
                v-model="search.language"
                :options="languages"
              />
            </div>
            <div class="col-sm-4 m-2">
              <BreezeLabel
                for="location"
                value="Localização"
              />
              <BreezeSelect
                id="location"
                v-model="search.location"
                :options="locations"
              />
            </div>
            <div class="p-2">
              <BreezeLabel
                for="sponsorable"
                value="Capacidade de Patrocínio"
              />
              <div class="flex items-center mt-1 p-1">
                <input
                  type="checkbox"
                  v-model="search.sponsorable"
                  class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                <span class="ml-2 text-base text-gray-700">
                  Disponível
                </span>
              </div>
            </div>
            <div class="p-2">
              <BreezeLabel
                for="repo"
                value="Repositórios"
              />
              <div class="grid grid-cols-2 gap-2">
                <BreezeInput
                  id="repo-min"
                  type="number"
                  class="mt-1 block"
                  v-model="search.repoMin"
                  min="1"
                  placeholder="Mín."
                  autocomplete="repoMin"
                />
                <BreezeInput
                  id="repo_max"
                  type="number"
                  class="mt-1 block"
                  v-model="search.repoMax"
                  min="1"
                  placeholder="Max."
                  autocomplete="repoMax"
                />
              </div>
            </div>
            <div class="p-2">
              <BreezeLabel
                for="repo"
                value="Seguidores"
              />
              <div class="grid grid-cols-2 gap-2">
                <BreezeInput
                  id="followers-min"
                  type="number"
                  class="mt-1"
                  v-model="search.followersMin"
                  min="1"
                  placeholder="Mín."
                  autocomplete="followersMin"
                />
                <BreezeInput
                  id="repo_max"
                  type="number"
                  class="mt-1"
                  v-model="search.followersMax"
                  min="1"
                  placeholder="Max."
                  autocomplete="followersMax"
                />
              </div>
            </div>
          </div>
        </Filters>
        <Table
          :columns="['Nome', '']"
          class="mt-2"
        >
          <tr
            v-for="dev in devs.items"
            :key="dev.id"
          >
            <td class="col px-6 py-4 whitespace-nowrap">
              <div class="flex-shrink-0 h-10 w-10">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <img
                      class="h-10 w-10 rounded-full"
                      :src="dev.avatar_url"
                      alt="Avatar"
                    />
                  </div>
                  <div class="ml-4">
                    <div class="text-md font-medium text-gray-900">
                      {{ dev.login }}
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <BreezeButton
                @click="devDetails(dev)"
                class="rounded-full"
                title="Detalhes"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4 fill-gray-700"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                  />
                </svg>
              </BreezeButton>
            </td>
          </tr>
        </Table>
        <div class="px-6 pb-4">
          <div class="flex flex-auto my-1">
            <span
              v-if="Object.keys(devs).length > 0"
              class="flex-1 text-right my-1 text-sm text-gray-500"
            >
              {{ devs.total_count }} registros encontrados
            </span>
          </div>
          <Pagination
            :page="search.page"
            @next="next"
            @previous="previous"
          />
        </div>
      </div>
      <TransitionRoot
        as="template"
        :show="isOpen"
      >
        <Dialog
          as="div"
          class="fixed z-10 inset-0 overflow-y-auto"
          @close="setIsOpen(false)"
        >
          <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <TransitionChild
              as="template"
              enter="ease-out duration-300"
              enter-from="opacity-0"
              enter-to="opacity-100"
              leave="ease-in duration-200"
              leave-from="opacity-100"
              leave-to="opacity-0"
            >
              <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span
              class="hidden sm:inline-block sm:align-middle sm:h-screen"
              aria-hidden="true"
            >&#8203;</span>
            <TransitionChild
              as="template"
              enter="ease-out duration-300"
              enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              enter-to="opacity-100 translate-y-0 sm:scale-100"
              leave="ease-in duration-200"
              leave-from="opacity-100 translate-y-0 sm:scale-100"
              leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
              <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                  <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-24 w-24 sm:mx-0">
                      <img
                        :src="devSelected.avatar_url"
                        class="rounded-full"
                        alt="Avatar url"
                      />

                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                      <div class="flex flex-col justify-between items-center sm:flex-row">
                        <DialogTitle
                          as="h3"
                          class="flex flex-col text-gray-800 max-w-full"
                        >
                          <span class="font-bold text-xl">
                            {{ devSelected.name }}
                          </span>
                          <span class="font-medium text-lg">{{ devSelected.login }}</span>
                        </DialogTitle>
                        <div
                          :class="pointsHighlight"
                          class="flex justify-center items-center text-5xl p-4 rounded-full"
                        >
                          <span class="text-gray-800">
                            {{ points }}
                          </span>
                        </div>
                        <!-- </div> -->
                      </div>
                      <div class="mt-4 sm:mt-2 space-y-2 sm:space-y-1">
                        <div
                          v-if="devSelected.company || false"
                          class="flex space-x-1 text-sm text-gray-700"
                        >
                          <svg
                            class="fill-gray-700 w-4 h-4"
                            viewBox="0 0 16 16"
                            version="1.1"
                            aria-hidden="true"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M1.5 14.25c0 .138.112.25.25.25H4v-1.25a.75.75 0 01.75-.75h2.5a.75.75 0 01.75.75v1.25h2.25a.25.25 0 00.25-.25V1.75a.25.25 0 00-.25-.25h-8.5a.25.25 0 00-.25.25v12.5zM1.75 16A1.75 1.75 0 010 14.25V1.75C0 .784.784 0 1.75 0h8.5C11.216 0 12 .784 12 1.75v12.5c0 .085-.006.168-.018.25h2.268a.25.25 0 00.25-.25V8.285a.25.25 0 00-.111-.208l-1.055-.703a.75.75 0 11.832-1.248l1.055.703c.487.325.779.871.779 1.456v5.965A1.75 1.75 0 0114.25 16h-3.5a.75.75 0 01-.197-.026c-.099.017-.2.026-.303.026h-3a.75.75 0 01-.75-.75V14h-1v1.25a.75.75 0 01-.75.75h-3zM3 3.75A.75.75 0 013.75 3h.5a.75.75 0 010 1.5h-.5A.75.75 0 013 3.75zM3.75 6a.75.75 0 000 1.5h.5a.75.75 0 000-1.5h-.5zM3 9.75A.75.75 0 013.75 9h.5a.75.75 0 010 1.5h-.5A.75.75 0 013 9.75zM7.75 9a.75.75 0 000 1.5h.5a.75.75 0 000-1.5h-.5zM7 6.75A.75.75 0 017.75 6h.5a.75.75 0 010 1.5h-.5A.75.75 0 017 6.75zM7.75 3a.75.75 0 000 1.5h.5a.75.75 0 000-1.5h-.5z"
                            ></path>
                          </svg>
                          <span>{{ devSelected.company }}</span>
                        </div>
                        <div
                          v-if="devSelected.location"
                          class="flex space-x-1 text-sm text-gray-700"
                        >
                          <svg
                            class="fill-gray-700 w-4 h-4"
                            viewBox="0 0 16 16"
                            version="1.1"
                            width="16"
                            height="16"
                            aria-hidden="true"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M11.536 3.464a5 5 0 010 7.072L8 14.07l-3.536-3.535a5 5 0 117.072-7.072v.001zm1.06 8.132a6.5 6.5 0 10-9.192 0l3.535 3.536a1.5 1.5 0 002.122 0l3.535-3.536zM8 9a2 2 0 100-4 2 2 0 000 4z"
                            ></path>
                          </svg>
                          <span>{{ devSelected.location }}</span>
                        </div>
                        <div class="flex space-x-1 text-sm text-gray-700">
                          <svg
                            class="fill-gray-700 w-4 h-4"
                            aria-hidden="true"
                            viewBox="0 0 16 16"
                            version="1.1"
                            data-view-component="true"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M5.5 3.5a2 2 0 100 4 2 2 0 000-4zM2 5.5a3.5 3.5 0 115.898 2.549 5.507 5.507 0 013.034 4.084.75.75 0 11-1.482.235 4.001 4.001 0 00-7.9 0 .75.75 0 01-1.482-.236A5.507 5.507 0 013.102 8.05 3.49 3.49 0 012 5.5zM11 4a.75.75 0 100 1.5 1.5 1.5 0 01.666 2.844.75.75 0 00-.416.672v.352a.75.75 0 00.574.73c1.2.289 2.162 1.2 2.522 2.372a.75.75 0 101.434-.44 5.01 5.01 0 00-2.56-3.012A3 3 0 0011 4z"
                            ></path>
                          </svg>
                          <span><strong>{{ devSelected.followers }}</strong> seguidores</span>
                          <span><strong>{{ devSelected.following }}</strong> seguindo</span>
                        </div>
                        <div class="flex space-x-1 text-sm text-gray-700">
                          <svg
                            class="fill-gray-700 w-4 h-4"
                            aria-hidden="true"
                            height="16"
                            viewBox="0 0 16 16"
                            version="1.1"
                            width="16"
                            data-view-component="true"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M2 2.5A2.5 2.5 0 014.5 0h8.75a.75.75 0 01.75.75v12.5a.75.75 0 01-.75.75h-2.5a.75.75 0 110-1.5h1.75v-2h-8a1 1 0 00-.714 1.7.75.75 0 01-1.072 1.05A2.495 2.495 0 012 11.5v-9zm10.5-1V9h-8c-.356 0-.694.074-1 .208V2.5a1 1 0 011-1h8zM5 12.25v3.25a.25.25 0 00.4.2l1.45-1.087a.25.25 0 01.3 0L8.6 15.7a.25.25 0 00.4-.2v-3.25a.25.25 0 00-.25-.25h-3.5a.25.25 0 00-.25.25z"
                            ></path>
                          </svg>
                          <span><strong>{{ devSelected.public_repos }}</strong> repos</span>
                          <span><strong>{{ devSelected.public_gists }}</strong> gists</span>
                        </div>
                        <div
                          v-if="devSelected.blog"
                          class="flex space-x-1 text-sm text-gray-700"
                        >
                          <svg
                            class="fill-gray-700 w-4 h-4"
                            aria-hidden="true"
                            viewBox="0 0 16 16"
                            version="1.1"
                            data-view-component="true"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M7.775 3.275a.75.75 0 001.06 1.06l1.25-1.25a2 2 0 112.83 2.83l-2.5 2.5a2 2 0 01-2.83 0 .75.75 0 00-1.06 1.06 3.5 3.5 0 004.95 0l2.5-2.5a3.5 3.5 0 00-4.95-4.95l-1.25 1.25zm-4.69 9.64a2 2 0 010-2.83l2.5-2.5a2 2 0 012.83 0 .75.75 0 001.06-1.06 3.5 3.5 0 00-4.95 0l-2.5 2.5a3.5 3.5 0 004.95 4.95l1.25-1.25a.75.75 0 00-1.06-1.06l-1.25 1.25a2 2 0 01-2.83 0z"
                            ></path>
                          </svg>
                          <a
                            :href="devSelected.blog"
                            class="hover:text-blue-500 hover:underline"
                            target="_blank"
                            rel="nofollow me"
                          >
                            {{ devSelected.blog }}
                          </a>
                        </div>
                        <div
                          v-if="devSelected.twitter_username"
                          class="flex space-x-1 text-sm text-gray-700"
                        >
                          <svg
                            class="fill-gray-700 w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 273.5 222.3"
                            role="img"
                            aria-labelledby="5x8pe2yzqmcthy8s6uy9lwcd38gtx2w"
                          >
                            <title id="5x8pe2yzqmcthy8s6uy9lwcd38gtx2w">Twitter</title>
                            <path
                              d="M273.5 26.3a109.77 109.77 0 0 1-32.2 8.8 56.07 56.07 0 0 0 24.7-31 113.39 113.39 0 0 1-35.7 13.6 56.1 56.1 0 0 0-97 38.4 54 54 0 0 0 1.5 12.8A159.68 159.68 0 0 1 19.1 10.3a56.12 56.12 0 0 0 17.4 74.9 56.06 56.06 0 0 1-25.4-7v.7a56.11 56.11 0 0 0 45 55 55.65 55.65 0 0 1-14.8 2 62.39 62.39 0 0 1-10.6-1 56.24 56.24 0 0 0 52.4 39 112.87 112.87 0 0 1-69.7 24 119 119 0 0 1-13.4-.8 158.83 158.83 0 0 0 86 25.2c103.2 0 159.6-85.5 159.6-159.6 0-2.4-.1-4.9-.2-7.3a114.25 114.25 0 0 0 28.1-29.1"
                              fill="currentColor"
                            ></path>
                          </svg>
                          <a
                            :href="`https://twitter.com/${devSelected.twitter_username}`"
                            class="hover:text-blue-500 hover:underline"
                            target="_blank"
                            rel="nofollow me"
                          >
                            @{{ devSelected.twitter_username }}
                          </a>
                        </div>
                      </div>
                      <div class="mt-4">
                        <p class="text-left text-gray-900">
                          {{ devSelected.bio }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button
                    type="button"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                    @click="isOpen = false"
                  >
                    Deactivate
                  </button>
                  <button
                    type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    @click="isOpen = false"
                    ref="cancelButtonRef"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>
    </template>
    <!-- <button
              class="bg-purple-300"
              title="Favoritar"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 fill-current hover:text-amber-400 rounded-full"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                />
              </svg>
            </button> -->
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeSelect from '@/Components/Select.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Filters from '@/Components/Filters.vue'
import Forbidden from '@/Components/Forbidden.vue'
import Pagination from '@/Components/Pagination.vue'
import Table from '@/Components/Table.vue'
import devsService from '@/services/developers'
import {
  Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot
} from "@headlessui/vue";
import { get } from '@/http'

export default {
  components: {
    BreezeAuthenticatedLayout,
    BreezeButton,
    BreezeCheckbox,
    BreezeInput,
    BreezeLabel,
    BreezeSelect,
    Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot,
    Filters,
    Forbidden,
    Head,
    Pagination,
    Table
  },
  computed: {
    points () {
      let points = 0
      const { blog, followers, hireable, public_repos, public_gists } = this.devSelected

      if (blog) points += 0.5
      if (hireable) ++points

      if (public_repos >= 50) ++points
      else if (public_repos >= 10) points += 0.5

      if (public_gists >= 10) points += 0.5

      if (followers >= 3000) points += 3
      else if (followers >= 2000) points += 2
      else if (followers >= 1000) ++points
      else if (followers >= 500) points += 0.5

      return points
    },
    pointsHighlight () {
      const points = this.points

      let highlights = ['border-2']

      highlights.push(Number.isInteger(points) ? 'w-20 h-20' : 'w-24 h-24')

      if (points >= 4) highlights.push('border-green-500 bg-green-100')
      else if (points >= 2) highlights.push('border-yellow-500 bg-yellow-100')
      else highlights.push(' border-red-500 bg-red-100')

      return highlights.join(' ')
    }
  },
  data () {
    return {
      devSelected: {},
      devs: {},
      isOpen: true,
      languages: [
        { text: 'PHP', val: 'php' },
        { text: 'JS', val: 'javascript' },
      ],
      locations: [
        { text: 'Brasil', val: 'brazil' },
        { text: 'Estados Unidos', val: 'usa' },
        { text: 'Portugal', val: 'portugal' },
      ],
      search: {}
    }
  },
  methods: {
    devDetails (dev) {
      get(dev.url)
        .then(data => {
          this.devSelected = data
          this.setIsOpen(true)
        })
    },
    getDevs (reset = false) {
      if (reset) this.search.page = 1

      devsService.get(this.search)
        .then(data => {
          this.devs = data
          this.devDetails(this.devs.items[0])
        })
    },
    next () {
      if (this.devs.total_count === 0 || (this.devs.total_count % this.search.per_page) > this.search.page) return
      ++this.search.page
      this.getDevs()
    },
    previous () {
      if (this.search.page <= 1) return
      --this.search.page
      this.getDevs()
    },
    resetSearch () {
      this.search = {
        name: '',
        location: undefined,
        language: undefined,
        sponsarable: false,
        page: 1,
        per_page: 10,
      }
    },
    setIsOpen (value) {
      this.isOpen = value;
    },
  },
  props: {
    can_access: Boolean
  },
  mounted () {
    this.resetSearch()
    this.getDevs()
  }
}
</script>

<style scoped>
input {
  color: rgb(55 65 81);
}
</style>