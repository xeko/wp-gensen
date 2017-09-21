<?php
global $employer_list, $jlpt_list;
$jlpt_list = array(
    '01' => 'N1',
    '02' => 'N2',
    '03' => 'N3',
    '04' => 'N4',
    '05' => 'Chưa thi tiếng nhật',
);
$employer_list = array(
    '01' => 'Du học sinh',
    '02' => 'Nghề tự do',
    '03' => 'Sinh viên',
    '04' => 'Nhân viên công ty',
    '05' => 'Nhân viên hợp đồng',
    '06' => 'Nội trợ',
    '07' => 'Không nghề nghiệp',
    '08' => 'Khác',
);

function func__job_employer() {
    global $employer_list;
    
    $employer_str = "<option value=''>- Lựa chọn -</option>";
    foreach ($employer_list as $key => $value):
        $employer_str .= "<option value='{$key}'>" . $value . "</option>";
    endforeach;
    return $employer_str;
}

add_shortcode('employer', 'func__job_employer');

function func___jlpt_level() {
    global $jlpt_list;
    
    $jlpt_str = "<option value=''>- Lựa chọn -</option>";
    foreach ($jlpt_list as $key => $value):
        $jlpt_str .= "<option value='{$key}'>" . $value . "</option>";
    endforeach;
    return $jlpt_str;
}

add_shortcode('japan_level', 'func___jlpt_level');
