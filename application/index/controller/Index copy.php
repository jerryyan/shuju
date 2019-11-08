<?php
namespace app\index\controller;

use think\Db;
use think\exception\DbException;

class Index
{
    public function index()
    {
        $sql = "select top 10 r.RegisterId,r.rname,rTel,r.OutpatientNumber,isAppointment,rMedia,rSymptom,rDepartment,a.awr,convert(varchar(100),r.ts,120) as ts,
        case when isAppointment=0 then '否' else '是' end as ysyy
        from dbo.Info_Registered r left join dbo.Info_Appointment a on r.AppointmentId = a.AppointmentId 
        where r.dr = 0   and r.cid = 1 ";
        $data=Db::connect('db_ydgc')->query($sql);
        var_dump($data);
        // $sql="select * from search";
        // $data=Db::connect('db_shuju')->query($sql);
        // halt($data);
    }
}
