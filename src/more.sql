--select join table ข้อมูลการจอง
SELECT bkd.bk_fullname,bkd.bk_tel,bkd.bk_line,bkd.bk_time,bk.bk_name,bk.bk_detail,ur.user_name FROM hm_booking_details bkd 
LEFT JOIN hm_booking bk
ON bkd.bk_id_fk = bk.bk_id
LEFT JOIN hm_user ur
ON bkd.hm_user_id = ur.user_id


-- Search หมอนวด ตามช่วงเวลา
SELECT ur.user_name FROM hm_booking_details bkd
LEFT JOIN hm_user ur
ON bkd.hm_user_id = ur.user_id
WHERE (bkd.bk_time BETWEEN  '15:00' AND '16:00')