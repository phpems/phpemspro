<?php

error_reporting(E_ERROR | E_PARSE);
define('TIME',time());
class config
{
    const defaultapp = 'content';

    const db = array(
        'default' => array(
            'host' => '127.0.0.1',
            'user' => 'root',
            'pass' => 'root',
            'name' => 'pep',
            'prefix' => 'x2_',
            'intro' => '主库'
        ),
        'demo' => array(
            'host' => '127.0.0.1',
            'user' => 'root',
            'pass' => 'root',
            'name' => 'pep2',
            'prefix' => 'x2_',
            'intro' => '分库'
        )
    );
    const dataformat = array(
        'default' => '默认',
        'timestamp' => 'UNIX时间戳',
        'split' => '逗号分隔',
        'json' => 'JSON编码',
        'serialize' => 'PHP序列化',
        'md5' => 'md5加密',
        'base64' => 'base64加密',
        'zipbase64' => '压缩后base64加密'
    );
    const dblog = 1;

    const redis = array(
        'default' => array(
            'host' => '127.0.0.1',
            'pass' => '',
            'name' => '0'
        ),
        'demo' => array(
            'host' => '127.0.0.1',
            'pass' => '',
            'name' => '1'
        )
    );

    const aliyunsms = array(
        'accessid' => 'LTAIV9vRehI439IJ',
        'accesskey' => 'dTgVDffHfpmnOLkd7MTcD8Nm211aWW',
        'signature' => '云考职宝'
    );

    const webpath = 'http://127.0.0.1/nf2/';
    const webencode = 'utf-8';
    const webpagenumber = 20;

    const cookieprefix = 'nf_';
    const cookiepath = '/';
    const cookiedomain = '';

    const systimezone = 'Asia/Shanghai';

    const usewechat = false;
    const wxappid = 'wxf47089c7d3df7f47';
    const wxsecret = '038305c974249f9d65690518bfc0585c';
    const wxmchid = '1510646931';
    const wxkey = 'YKZBAO32qrdsds341huefd242211oplk';

    const aliappid = '2019011663020685';
    const alikey = 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDE4TlOKjcU02QA
                    y7d2uy2IxZI9kxF0Jx98Mz+jhgUv7dCk7DQ1Mihc1H5tQZIH8QeymfD1DepKT8jN
                    fISzijFWPPAYCxUEjc8QpCW1io2nk3bfenYddfJi2L/wNyHfrhuOcewVjbyuo9ja
                    KPyeCx6JZiZHmgeFZVGGT1r2wgGhOOWG5siXpV8oaRPxtFCTvgkL3j5924pOQ79e
                    ZSPSOvJRYMA4nVeiIJMJfWXMjLHwUyUEB5o+p4E3ghqL0h6Pa3igRXi/hyqrpnqe
                    jiumI7wF5shuEui3VgNuWTRiI54XqxVu2fK+jDuDE5FOXjmTBrrEJ/nCDGbLgR4l
                    NlKUM8RnAgMBAAECggEAd3O7RCyi3NThQQZZGwW4O9q7vvZDSbkPBllFzF5dOVZO
                    GDJj/r6e9KvMxVdaVc0tAXUbWGOH+mxsBhj9nr1C7/LrLXtT1j6AGrWtV3doOPtk
                    zXTMw1UzqjueQQ4CVGebupJuTimACGnLAZqKow1WCsFaimjvFUWC8D2nkD3npTwC
                    KbskFtu8bOG2AtscmeZbRtOSmRxSaYLZARwRMXIkTyiievX8NZuuCONZHScP6qvk
                    tfIAgmvTpa/VpzhpIOf74yBpj3Sw5/bY4nna9pc87YTqBFWwHnZdBLdLJdLhVRgU
                    UGgMQkxJBAk4jJG7N6lE8T7ubo01sRmjFxUUCtGlaQKBgQDv084RlWAepWoPNqC4
                    GjP0yoltMRE1vsnGnABWBUQiIiLuhnpfN9sW0x7rU86M5KryDlgv4JGSVdSIpuX2
                    vsGreEIv5/86/hp6o4MpT8Tr0ObK7zIlsfJiG3dFpHiY2cDm5gH6W7iVJnz+5FnB
                    sWzH62BpuO300jAffwMZC8sh0wKBgQDSKAE/vgIK2IUF0lSRAaYDWph3haVpHlf7
                    PqftEufuB6QL3FRHbuAbJAsrNVqB7Ieh6Mj3L7WkzrBWC3yPlus4gVcV4N8ChKWc
                    oaubGU2iDA3rPetCblWUPAgUWGihGmSTIkZzdJYKjM7wySvj8w74jdpsCxQUBsbE
                    OY/N8hYinQKBgDHoO6vBD/2Qop+D2LI3EbTRKQQF//TVPRwNfqxn8CPCQs6sQW7r
                    KrZ3PKnwCL2dIE262nMsIl73aYD+akCMtbS/E9bwSla2ZkA7IqJILUx9bmmwmRjr
                    DOuJl6pwbYAxYEkseCDnUWQIXF6Wmm8KQv7fZnLZvvsBem4zeiuOHrltAoGBAMhU
                    vEQQE5BVMBEJm/WStbdSwC6HZtOaylHFO3yh3hcoj3eC85AYoGce58qrlHhviieM
                    aS5A+418Pdn4HygdvGJj4SkI8G1NFzYFYzl5WGjVxtrtbnsoBEpHI4iJckvIhgE/
                    1hqvE2xBJ++eRUmJZEcJqiH+OYiRoR5ipLO0Rud9AoGAXYvmEGxCJQit0DM7BVkD
                    tYuPwkunp39cl5YSOMhra+8JBDrNtUdKoixoyIKy2ycDUFzPEQF+q9SxN5BlZvL9
                    ls3BhvNE0k0+pJZ8zsHmfdMFBamYmwGA5YbKKgPBULru+1NU6AHmXm0S01iVeyVQ
                    Dt0IeYUUgxFBMXcfCJG09ec=';
    const alipub = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAo2zi62n//l+bOIZ7dnHx
                    jw8/p9UC9g9MRUo7f9pseV51FhVmVVEUj5tAEnEXnAhngSWRG1u8g3zQV03jZBDj
                    XsGEQq6K5ov8JP0X9nYKUkcwTS3DYCtL8Z1UTqNhlHv2q89n1uTuBsR9Yv30T5FO
                    Ida1q/Bs4asKGV897M8ahzcClNkBRmUl8cOXYVpjsEPVfm6Ev6wiDl0zTlYbmJZF
                    RtNl8tQStXO4rQIsrrZVKnBeLKaniCQy6cSAIQBAkhx65ikAD5QB7Ex4ra2kYFxX
                    Br2Cfl+GIahSgRMTCAjnJ/0zBW2vb1Gnsbb2Y4gR2PQpZlgtZr/7UnJiVWc6Pnmc
                    DQIDAQAB';
}