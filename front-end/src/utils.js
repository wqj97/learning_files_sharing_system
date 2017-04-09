export const ids =        [2        ,4        ,8      ,16    ,32       ,64      ,128    ]
export const titleList = ['科目精华', '科目习题', '英语', '考研', '资格考试', '课外资料', '其他']
export function getCategroyListById(id) {
  id = Number(id)
  return titleList[ids.indexOf(id)]
}
