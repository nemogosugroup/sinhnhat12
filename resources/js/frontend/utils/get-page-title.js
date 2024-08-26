import defaultSettings from '@frontend/settings'

const title = defaultSettings.title || 'GOSU'

export default function getPageTitle(pageTitle) {
  if (pageTitle) {
    return `${pageTitle} - ${title}`
  }
  return `${title}`
}
