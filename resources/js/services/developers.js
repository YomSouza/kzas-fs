import http from '@/http'

const API_DEVS_GIT = 'https://api.github.com/search/users'
const API_DEVS_TRENDING = 'https://gh-trending-api.herokuapp.com/'

const get = (params) => {
  const {
    name,
    language,
    location,
    repoMin = '*',
    repoMax = '*',
    followersMin = '*',
    followersMax = '*',
    page = 1,
    per_page = 20,
    type = 'user',
    sponsorable = false
  } = params

  let q = name || ''//`${name} repos:${repoMin}..${repoMax}`

  if (followersMin !== '*' || followersMax !== '*') q += ` followers:${followersMin}..${followersMax}`
  if (repoMin !== '*' || repoMax !== '*') q += ` repos:${repoMin}..${repoMax}`
  if (language) q += ` language:${language}`
  if (location) q += ` location:${location}`
  if (sponsorable) q += ' is:sponsorable'

  return http.get(`${API_DEVS_GIT}?` + new URLSearchParams({
    q,
    page,
    per_page,
    type,
  }))
}

export default {
  get,
  // trending: (params) => http.get(API_DEVS_TRENDING, params),
}