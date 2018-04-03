export const ids = [2, 4, 8, 16, 32, 64, 128, 256]
export const titleList = ['中医精华', '中医习题', '西医精华', '西医习题', '护理精华', '护理习题', '临床医案', '课外书籍']

export function getCategroyListById (id) {
  id = Number(id)
  return titleList[ids.indexOf(id)]
}

export const assetsPath = process.env.NODE_ENV === 'development' ? '/static/' : '/home/static/'

export function isComputer () {
  let platform = window.navigator.platform
  console.log(platform)
  return /(mac|win|x11)/.test(platform.toLowerCase())
}
