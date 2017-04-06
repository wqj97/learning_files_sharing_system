const ids =        [2        ,4        ,8      ,16    ,32       ,64      ,128    ]
const titleList = ['科目习题', '科目精华', '英语', '考研', '资格考试', '工具书', '其他']
export function getCategroyListById(id) {
  id = Number(id)
  return titleList[ids.indexOf(id)]
}
