export const ids =        [2        ,4        ,8      ,16    ,32       ,64         ,128,  256  ]
export const titleList = ['中医', '西医', '护理', '药学', '中西医结合', '课外资料','病例', '其他']
export function getCategroyListById(id) {
  id = Number(id)
  return titleList[ids.indexOf(id)]
}
export const assetsPath = process.env.NODE_ENV === 'development' ?  '/static/' : '/home/static/'

export function isComputer() {
  let platform = window.navigator.platform
  console.log(platform)
  return /(mac|win|x11)/.test(platform.toLowerCase())
}
