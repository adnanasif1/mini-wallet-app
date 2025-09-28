import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

let echo: Echo

export function initEcho(token: string) {
  window.Pusher = Pusher

  echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: `${import.meta.env.VITE_API_URL}/broadcasting/auth`,
    auth: {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    },
  })

  return echo
}

export function getEcho() {
  return echo
}
