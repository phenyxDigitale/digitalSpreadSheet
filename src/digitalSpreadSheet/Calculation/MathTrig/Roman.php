<?php

namespace phenyxDigitale\digitalSpreadSheet\Calculation\MathTrig;

use phenyxDigitale\digitalSpreadSheet\Calculation\ArrayEnabled;
use phenyxDigitale\digitalSpreadSheet\Calculation\Exception;
use phenyxDigitale\digitalSpreadSheet\Calculation\Information\ExcelError;

class Roman
{
    use ArrayEnabled;

    private const VALUES = [
        45 => ['VL'],
        46 => ['VLI'],
        47 => ['VLII'],
        48 => ['VLIII'],
        49 => ['VLIV', 'IL'],
        95 => ['VC'],
        96 => ['VCI'],
        97 => ['VCII'],
        98 => ['VCIII'],
        99 => ['VCIV', 'IC'],
        145 => ['CVL'],
        146 => ['CVLI'],
        147 => ['CVLII'],
        148 => ['CVLIII'],
        149 => ['CVLIV', 'CIL'],
        195 => ['CVC'],
        196 => ['CVCI'],
        197 => ['CVCII'],
        198 => ['CVCIII'],
        199 => ['CVCIV', 'CIC'],
        245 => ['CCVL'],
        246 => ['CCVLI'],
        247 => ['CCVLII'],
        248 => ['CCVLIII'],
        249 => ['CCVLIV', 'CCIL'],
        295 => ['CCVC'],
        296 => ['CCVCI'],
        297 => ['CCVCII'],
        298 => ['CCVCIII'],
        299 => ['CCVCIV', 'CCIC'],
        345 => ['CCCVL'],
        346 => ['CCCVLI'],
        347 => ['CCCVLII'],
        348 => ['CCCVLIII'],
        349 => ['CCCVLIV', 'CCCIL'],
        395 => ['CCCVC'],
        396 => ['CCCVCI'],
        397 => ['CCCVCII'],
        398 => ['CCCVCIII'],
        399 => ['CCCVCIV', 'CCCIC'],
        445 => ['CDVL'],
        446 => ['CDVLI'],
        447 => ['CDVLII'],
        448 => ['CDVLIII'],
        449 => ['CDVLIV', 'CDIL'],
        450 => ['LD'],
        451 => ['LDI'],
        452 => ['LDII'],
        453 => ['LDIII'],
        454 => ['LDIV'],
        455 => ['LDV'],
        456 => ['LDVI'],
        457 => ['LDVII'],
        458 => ['LDVIII'],
        459 => ['LDIX'],
        460 => ['LDX'],
        461 => ['LDXI'],
        462 => ['LDXII'],
        463 => ['LDXIII'],
        464 => ['LDXIV'],
        465 => ['LDXV'],
        466 => ['LDXVI'],
        467 => ['LDXVII'],
        468 => ['LDXVIII'],
        469 => ['LDXIX'],
        470 => ['LDXX'],
        471 => ['LDXXI'],
        472 => ['LDXXII'],
        473 => ['LDXXIII'],
        474 => ['LDXXIV'],
        475 => ['LDXXV'],
        476 => ['LDXXVI'],
        477 => ['LDXXVII'],
        478 => ['LDXXVIII'],
        479 => ['LDXXIX'],
        480 => ['LDXXX'],
        481 => ['LDXXXI'],
        482 => ['LDXXXII'],
        483 => ['LDXXXIII'],
        484 => ['LDXXXIV'],
        485 => ['LDXXXV'],
        486 => ['LDXXXVI'],
        487 => ['LDXXXVII'],
        488 => ['LDXXXVIII'],
        489 => ['LDXXXIX'],
        490 => ['LDXL', 'XD'],
        491 => ['LDXLI', 'XDI'],
        492 => ['LDXLII', 'XDII'],
        493 => ['LDXLIII', 'XDIII'],
        494 => ['LDXLIV', 'XDIV'],
        495 => ['LDVL', 'XDV', 'VD'],
        496 => ['LDVLI', 'XDVI', 'VDI'],
        497 => ['LDVLII', 'XDVII', 'VDII'],
        498 => ['LDVLIII', 'XDVIII', 'VDIII'],
        499 => ['LDVLIV', 'XDIX', 'VDIV', 'ID'],
        545 => ['DVL'],
        546 => ['DVLI'],
        547 => ['DVLII'],
        548 => ['DVLIII'],
        549 => ['DVLIV', 'DIL'],
        595 => ['DVC'],
        596 => ['DVCI'],
        597 => ['DVCII'],
        598 => ['DVCIII'],
        599 => ['DVCIV', 'DIC'],
        645 => ['DCVL'],
        646 => ['DCVLI'],
        647 => ['DCVLII'],
        648 => ['DCVLIII'],
        649 => ['DCVLIV', 'DCIL'],
        695 => ['DCVC'],
        696 => ['DCVCI'],
        697 => ['DCVCII'],
        698 => ['DCVCIII'],
        699 => ['DCVCIV', 'DCIC'],
        745 => ['DCCVL'],
        746 => ['DCCVLI'],
        747 => ['DCCVLII'],
        748 => ['DCCVLIII'],
        749 => ['DCCVLIV', 'DCCIL'],
        795 => ['DCCVC'],
        796 => ['DCCVCI'],
        797 => ['DCCVCII'],
        798 => ['DCCVCIII'],
        799 => ['DCCVCIV', 'DCCIC'],
        845 => ['DCCCVL'],
        846 => ['DCCCVLI'],
        847 => ['DCCCVLII'],
        848 => ['DCCCVLIII'],
        849 => ['DCCCVLIV', 'DCCCIL'],
        895 => ['DCCCVC'],
        896 => ['DCCCVCI'],
        897 => ['DCCCVCII'],
        898 => ['DCCCVCIII'],
        899 => ['DCCCVCIV', 'DCCCIC'],
        945 => ['CMVL'],
        946 => ['CMVLI'],
        947 => ['CMVLII'],
        948 => ['CMVLIII'],
        949 => ['CMVLIV', 'CMIL'],
        950 => ['LM'],
        951 => ['LMI'],
        952 => ['LMII'],
        953 => ['LMIII'],
        954 => ['LMIV'],
        955 => ['LMV'],
        956 => ['LMVI'],
        957 => ['LMVII'],
        958 => ['LMVIII'],
        959 => ['LMIX'],
        960 => ['LMX'],
        961 => ['LMXI'],
        962 => ['LMXII'],
        963 => ['LMXIII'],
        964 => ['LMXIV'],
        965 => ['LMXV'],
        966 => ['LMXVI'],
        967 => ['LMXVII'],
        968 => ['LMXVIII'],
        969 => ['LMXIX'],
        970 => ['LMXX'],
        971 => ['LMXXI'],
        972 => ['LMXXII'],
        973 => ['LMXXIII'],
        974 => ['LMXXIV'],
        975 => ['LMXXV'],
        976 => ['LMXXVI'],
        977 => ['LMXXVII'],
        978 => ['LMXXVIII'],
        979 => ['LMXXIX'],
        980 => ['LMXXX'],
        981 => ['LMXXXI'],
        982 => ['LMXXXII'],
        983 => ['LMXXXIII'],
        984 => ['LMXXXIV'],
        985 => ['LMXXXV'],
        986 => ['LMXXXVI'],
        987 => ['LMXXXVII'],
        988 => ['LMXXXVIII'],
        989 => ['LMXXXIX'],
        990 => ['LMXL', 'XM'],
        991 => ['LMXLI', 'XMI'],
        992 => ['LMXLII', 'XMII'],
        993 => ['LMXLIII', 'XMIII'],
        994 => ['LMXLIV', 'XMIV'],
        995 => ['LMVL', 'XMV', 'VM'],
        996 => ['LMVLI', 'XMVI', 'VMI'],
        997 => ['LMVLII', 'XMVII', 'VMII'],
        998 => ['LMVLIII', 'XMVIII', 'VMIII'],
        999 => ['LMVLIV', 'XMIX', 'VMIV', 'IM'],
        1045 => ['MVL'],
        1046 => ['MVLI'],
        1047 => ['MVLII'],
        1048 => ['MVLIII'],
        1049 => ['MVLIV', 'MIL'],
        1095 => ['MVC'],
        1096 => ['MVCI'],
        1097 => ['MVCII'],
        1098 => ['MVCIII'],
        1099 => ['MVCIV', 'MIC'],
        1145 => ['MCVL'],
        1146 => ['MCVLI'],
        1147 => ['MCVLII'],
        1148 => ['MCVLIII'],
        1149 => ['MCVLIV', 'MCIL'],
        1195 => ['MCVC'],
        1196 => ['MCVCI'],
        1197 => ['MCVCII'],
        1198 => ['MCVCIII'],
        1199 => ['MCVCIV', 'MCIC'],
        1245 => ['MCCVL'],
        1246 => ['MCCVLI'],
        1247 => ['MCCVLII'],
        1248 => ['MCCVLIII'],
        1249 => ['MCCVLIV', 'MCCIL'],
        1295 => ['MCCVC'],
        1296 => ['MCCVCI'],
        1297 => ['MCCVCII'],
        1298 => ['MCCVCIII'],
        1299 => ['MCCVCIV', 'MCCIC'],
        1345 => ['MCCCVL'],
        1346 => ['MCCCVLI'],
        1347 => ['MCCCVLII'],
        1348 => ['MCCCVLIII'],
        1349 => ['MCCCVLIV', 'MCCCIL'],
        1395 => ['MCCCVC'],
        1396 => ['MCCCVCI'],
        1397 => ['MCCCVCII'],
        1398 => ['MCCCVCIII'],
        1399 => ['MCCCVCIV', 'MCCCIC'],
        1445 => ['MCDVL'],
        1446 => ['MCDVLI'],
        1447 => ['MCDVLII'],
        1448 => ['MCDVLIII'],
        1449 => ['MCDVLIV', 'MCDIL'],
        1450 => ['MLD'],
        1451 => ['MLDI'],
        1452 => ['MLDII'],
        1453 => ['MLDIII'],
        1454 => ['MLDIV'],
        1455 => ['MLDV'],
        1456 => ['MLDVI'],
        1457 => ['MLDVII'],
        1458 => ['MLDVIII'],
        1459 => ['MLDIX'],
        1460 => ['MLDX'],
        1461 => ['MLDXI'],
        1462 => ['MLDXII'],
        1463 => ['MLDXIII'],
        1464 => ['MLDXIV'],
        1465 => ['MLDXV'],
        1466 => ['MLDXVI'],
        1467 => ['MLDXVII'],
        1468 => ['MLDXVIII'],
        1469 => ['MLDXIX'],
        1470 => ['MLDXX'],
        1471 => ['MLDXXI'],
        1472 => ['MLDXXII'],
        1473 => ['MLDXXIII'],
        1474 => ['MLDXXIV'],
        1475 => ['MLDXXV'],
        1476 => ['MLDXXVI'],
        1477 => ['MLDXXVII'],
        1478 => ['MLDXXVIII'],
        1479 => ['MLDXXIX'],
        1480 => ['MLDXXX'],
        1481 => ['MLDXXXI'],
        1482 => ['MLDXXXII'],
        1483 => ['MLDXXXIII'],
        1484 => ['MLDXXXIV'],
        1485 => ['MLDXXXV'],
        1486 => ['MLDXXXVI'],
        1487 => ['MLDXXXVII'],
        1488 => ['MLDXXXVIII'],
        1489 => ['MLDXXXIX'],
        1490 => ['MLDXL', 'MXD'],
        1491 => ['MLDXLI', 'MXDI'],
        1492 => ['MLDXLII', 'MXDII'],
        1493 => ['MLDXLIII', 'MXDIII'],
        1494 => ['MLDXLIV', 'MXDIV'],
        1495 => ['MLDVL', 'MXDV', 'MVD'],
        1496 => ['MLDVLI', 'MXDVI', 'MVDI'],
        1497 => ['MLDVLII', 'MXDVII', 'MVDII'],
        1498 => ['MLDVLIII', 'MXDVIII', 'MVDIII'],
        1499 => ['MLDVLIV', 'MXDIX', 'MVDIV', 'MID'],
        1545 => ['MDVL'],
        1546 => ['MDVLI'],
        1547 => ['MDVLII'],
        1548 => ['MDVLIII'],
        1549 => ['MDVLIV', 'MDIL'],
        1595 => ['MDVC'],
        1596 => ['MDVCI'],
        1597 => ['MDVCII'],
        1598 => ['MDVCIII'],
        1599 => ['MDVCIV', 'MDIC'],
        1645 => ['MDCVL'],
        1646 => ['MDCVLI'],
        1647 => ['MDCVLII'],
        1648 => ['MDCVLIII'],
        1649 => ['MDCVLIV', 'MDCIL'],
        1695 => ['MDCVC'],
        1696 => ['MDCVCI'],
        1697 => ['MDCVCII'],
        1698 => ['MDCVCIII'],
        1699 => ['MDCVCIV', 'MDCIC'],
        1745 => ['MDCCVL'],
        1746 => ['MDCCVLI'],
        1747 => ['MDCCVLII'],
        1748 => ['MDCCVLIII'],
        1749 => ['MDCCVLIV', 'MDCCIL'],
        1795 => ['MDCCVC'],
        1796 => ['MDCCVCI'],
        1797 => ['MDCCVCII'],
        1798 => ['MDCCVCIII'],
        1799 => ['MDCCVCIV', 'MDCCIC'],
        1845 => ['MDCCCVL'],
        1846 => ['MDCCCVLI'],
        1847 => ['MDCCCVLII'],
        1848 => ['MDCCCVLIII'],
        1849 => ['MDCCCVLIV', 'MDCCCIL'],
        1895 => ['MDCCCVC'],
        1896 => ['MDCCCVCI'],
        1897 => ['MDCCCVCII'],
        1898 => ['MDCCCVCIII'],
        1899 => ['MDCCCVCIV', 'MDCCCIC'],
        1945 => ['MCMVL'],
        1946 => ['MCMVLI'],
        1947 => ['MCMVLII'],
        1948 => ['MCMVLIII'],
        1949 => ['MCMVLIV', 'MCMIL'],
        1950 => ['MLM'],
        1951 => ['MLMI'],
        1952 => ['MLMII'],
        1953 => ['MLMIII'],
        1954 => ['MLMIV'],
        1955 => ['MLMV'],
        1956 => ['MLMVI'],
        1957 => ['MLMVII'],
        1958 => ['MLMVIII'],
        1959 => ['MLMIX'],
        1960 => ['MLMX'],
        1961 => ['MLMXI'],
        1962 => ['MLMXII'],
        1963 => ['MLMXIII'],
        1964 => ['MLMXIV'],
        1965 => ['MLMXV'],
        1966 => ['MLMXVI'],
        1967 => ['MLMXVII'],
        1968 => ['MLMXVIII'],
        1969 => ['MLMXIX'],
        1970 => ['MLMXX'],
        1971 => ['MLMXXI'],
        1972 => ['MLMXXII'],
        1973 => ['MLMXXIII'],
        1974 => ['MLMXXIV'],
        1975 => ['MLMXXV'],
        1976 => ['MLMXXVI'],
        1977 => ['MLMXXVII'],
        1978 => ['MLMXXVIII'],
        1979 => ['MLMXXIX'],
        1980 => ['MLMXXX'],
        1981 => ['MLMXXXI'],
        1982 => ['MLMXXXII'],
        1983 => ['MLMXXXIII'],
        1984 => ['MLMXXXIV'],
        1985 => ['MLMXXXV'],
        1986 => ['MLMXXXVI'],
        1987 => ['MLMXXXVII'],
        1988 => ['MLMXXXVIII'],
        1989 => ['MLMXXXIX'],
        1990 => ['MLMXL', 'MXM'],
        1991 => ['MLMXLI', 'MXMI'],
        1992 => ['MLMXLII', 'MXMII'],
        1993 => ['MLMXLIII', 'MXMIII'],
        1994 => ['MLMXLIV', 'MXMIV'],
        1995 => ['MLMVL', 'MXMV', 'MVM'],
        1996 => ['MLMVLI', 'MXMVI', 'MVMI'],
        1997 => ['MLMVLII', 'MXMVII', 'MVMII'],
        1998 => ['MLMVLIII', 'MXMVIII', 'MVMIII'],
        1999 => ['MLMVLIV', 'MXMIX', 'MVMIV', 'MIM'],
        2045 => ['MMVL'],
        2046 => ['MMVLI'],
        2047 => ['MMVLII'],
        2048 => ['MMVLIII'],
        2049 => ['MMVLIV', 'MMIL'],
        2095 => ['MMVC'],
        2096 => ['MMVCI'],
        2097 => ['MMVCII'],
        2098 => ['MMVCIII'],
        2099 => ['MMVCIV', 'MMIC'],
        2145 => ['MMCVL'],
        2146 => ['MMCVLI'],
        2147 => ['MMCVLII'],
        2148 => ['MMCVLIII'],
        2149 => ['MMCVLIV', 'MMCIL'],
        2195 => ['MMCVC'],
        2196 => ['MMCVCI'],
        2197 => ['MMCVCII'],
        2198 => ['MMCVCIII'],
        2199 => ['MMCVCIV', 'MMCIC'],
        2245 => ['MMCCVL'],
        2246 => ['MMCCVLI'],
        2247 => ['MMCCVLII'],
        2248 => ['MMCCVLIII'],
        2249 => ['MMCCVLIV', 'MMCCIL'],
        2295 => ['MMCCVC'],
        2296 => ['MMCCVCI'],
        2297 => ['MMCCVCII'],
        2298 => ['MMCCVCIII'],
        2299 => ['MMCCVCIV', 'MMCCIC'],
        2345 => ['MMCCCVL'],
        2346 => ['MMCCCVLI'],
        2347 => ['MMCCCVLII'],
        2348 => ['MMCCCVLIII'],
        2349 => ['MMCCCVLIV', 'MMCCCIL'],
        2395 => ['MMCCCVC'],
        2396 => ['MMCCCVCI'],
        2397 => ['MMCCCVCII'],
        2398 => ['MMCCCVCIII'],
        2399 => ['MMCCCVCIV', 'MMCCCIC'],
        2445 => ['MMCDVL'],
        2446 => ['MMCDVLI'],
        2447 => ['MMCDVLII'],
        2448 => ['MMCDVLIII'],
        2449 => ['MMCDVLIV', 'MMCDIL'],
        2450 => ['MMLD'],
        2451 => ['MMLDI'],
        2452 => ['MMLDII'],
        2453 => ['MMLDIII'],
        2454 => ['MMLDIV'],
        2455 => ['MMLDV'],
        2456 => ['MMLDVI'],
        2457 => ['MMLDVII'],
        2458 => ['MMLDVIII'],
        2459 => ['MMLDIX'],
        2460 => ['MMLDX'],
        2461 => ['MMLDXI'],
        2462 => ['MMLDXII'],
        2463 => ['MMLDXIII'],
        2464 => ['MMLDXIV'],
        2465 => ['MMLDXV'],
        2466 => ['MMLDXVI'],
        2467 => ['MMLDXVII'],
        2468 => ['MMLDXVIII'],
        2469 => ['MMLDXIX'],
        2470 => ['MMLDXX'],
        2471 => ['MMLDXXI'],
        2472 => ['MMLDXXII'],
        2473 => ['MMLDXXIII'],
        2474 => ['MMLDXXIV'],
        2475 => ['MMLDXXV'],
        2476 => ['MMLDXXVI'],
        2477 => ['MMLDXXVII'],
        2478 => ['MMLDXXVIII'],
        2479 => ['MMLDXXIX'],
        2480 => ['MMLDXXX'],
        2481 => ['MMLDXXXI'],
        2482 => ['MMLDXXXII'],
        2483 => ['MMLDXXXIII'],
        2484 => ['MMLDXXXIV'],
        2485 => ['MMLDXXXV'],
        2486 => ['MMLDXXXVI'],
        2487 => ['MMLDXXXVII'],
        2488 => ['MMLDXXXVIII'],
        2489 => ['MMLDXXXIX'],
        2490 => ['MMLDXL', 'MMXD'],
        2491 => ['MMLDXLI', 'MMXDI'],
        2492 => ['MMLDXLII', 'MMXDII'],
        2493 => ['MMLDXLIII', 'MMXDIII'],
        2494 => ['MMLDXLIV', 'MMXDIV'],
        2495 => ['MMLDVL', 'MMXDV', 'MMVD'],
        2496 => ['MMLDVLI', 'MMXDVI', 'MMVDI'],
        2497 => ['MMLDVLII', 'MMXDVII', 'MMVDII'],
        2498 => ['MMLDVLIII', 'MMXDVIII', 'MMVDIII'],
        2499 => ['MMLDVLIV', 'MMXDIX', 'MMVDIV', 'MMID'],
        2545 => ['MMDVL'],
        2546 => ['MMDVLI'],
        2547 => ['MMDVLII'],
        2548 => ['MMDVLIII'],
        2549 => ['MMDVLIV', 'MMDIL'],
        2595 => ['MMDVC'],
        2596 => ['MMDVCI'],
        2597 => ['MMDVCII'],
        2598 => ['MMDVCIII'],
        2599 => ['MMDVCIV', 'MMDIC'],
        2645 => ['MMDCVL'],
        2646 => ['MMDCVLI'],
        2647 => ['MMDCVLII'],
        2648 => ['MMDCVLIII'],
        2649 => ['MMDCVLIV', 'MMDCIL'],
        2695 => ['MMDCVC'],
        2696 => ['MMDCVCI'],
        2697 => ['MMDCVCII'],
        2698 => ['MMDCVCIII'],
        2699 => ['MMDCVCIV', 'MMDCIC'],
        2745 => ['MMDCCVL'],
        2746 => ['MMDCCVLI'],
        2747 => ['MMDCCVLII'],
        2748 => ['MMDCCVLIII'],
        2749 => ['MMDCCVLIV', 'MMDCCIL'],
        2795 => ['MMDCCVC'],
        2796 => ['MMDCCVCI'],
        2797 => ['MMDCCVCII'],
        2798 => ['MMDCCVCIII'],
        2799 => ['MMDCCVCIV', 'MMDCCIC'],
        2845 => ['MMDCCCVL'],
        2846 => ['MMDCCCVLI'],
        2847 => ['MMDCCCVLII'],
        2848 => ['MMDCCCVLIII'],
        2849 => ['MMDCCCVLIV', 'MMDCCCIL'],
        2895 => ['MMDCCCVC'],
        2896 => ['MMDCCCVCI'],
        2897 => ['MMDCCCVCII'],
        2898 => ['MMDCCCVCIII'],
        2899 => ['MMDCCCVCIV', 'MMDCCCIC'],
        2945 => ['MMCMVL'],
        2946 => ['MMCMVLI'],
        2947 => ['MMCMVLII'],
        2948 => ['MMCMVLIII'],
        2949 => ['MMCMVLIV', 'MMCMIL'],
        2950 => ['MMLM'],
        2951 => ['MMLMI'],
        2952 => ['MMLMII'],
        2953 => ['MMLMIII'],
        2954 => ['MMLMIV'],
        2955 => ['MMLMV'],
        2956 => ['MMLMVI'],
        2957 => ['MMLMVII'],
        2958 => ['MMLMVIII'],
        2959 => ['MMLMIX'],
        2960 => ['MMLMX'],
        2961 => ['MMLMXI'],
        2962 => ['MMLMXII'],
        2963 => ['MMLMXIII'],
        2964 => ['MMLMXIV'],
        2965 => ['MMLMXV'],
        2966 => ['MMLMXVI'],
        2967 => ['MMLMXVII'],
        2968 => ['MMLMXVIII'],
        2969 => ['MMLMXIX'],
        2970 => ['MMLMXX'],
        2971 => ['MMLMXXI'],
        2972 => ['MMLMXXII'],
        2973 => ['MMLMXXIII'],
        2974 => ['MMLMXXIV'],
        2975 => ['MMLMXXV'],
        2976 => ['MMLMXXVI'],
        2977 => ['MMLMXXVII'],
        2978 => ['MMLMXXVIII'],
        2979 => ['MMLMXXIX'],
        2980 => ['MMLMXXX'],
        2981 => ['MMLMXXXI'],
        2982 => ['MMLMXXXII'],
        2983 => ['MMLMXXXIII'],
        2984 => ['MMLMXXXIV'],
        2985 => ['MMLMXXXV'],
        2986 => ['MMLMXXXVI'],
        2987 => ['MMLMXXXVII'],
        2988 => ['MMLMXXXVIII'],
        2989 => ['MMLMXXXIX'],
        2990 => ['MMLMXL', 'MMXM'],
        2991 => ['MMLMXLI', 'MMXMI'],
        2992 => ['MMLMXLII', 'MMXMII'],
        2993 => ['MMLMXLIII', 'MMXMIII'],
        2994 => ['MMLMXLIV', 'MMXMIV'],
        2995 => ['MMLMVL', 'MMXMV', 'MMVM'],
        2996 => ['MMLMVLI', 'MMXMVI', 'MMVMI'],
        2997 => ['MMLMVLII', 'MMXMVII', 'MMVMII'],
        2998 => ['MMLMVLIII', 'MMXMVIII', 'MMVMIII'],
        2999 => ['MMLMVLIV', 'MMXMIX', 'MMVMIV', 'MMIM'],
        3045 => ['MMMVL'],
        3046 => ['MMMVLI'],
        3047 => ['MMMVLII'],
        3048 => ['MMMVLIII'],
        3049 => ['MMMVLIV', 'MMMIL'],
        3095 => ['MMMVC'],
        3096 => ['MMMVCI'],
        3097 => ['MMMVCII'],
        3098 => ['MMMVCIII'],
        3099 => ['MMMVCIV', 'MMMIC'],
        3145 => ['MMMCVL'],
        3146 => ['MMMCVLI'],
        3147 => ['MMMCVLII'],
        3148 => ['MMMCVLIII'],
        3149 => ['MMMCVLIV', 'MMMCIL'],
        3195 => ['MMMCVC'],
        3196 => ['MMMCVCI'],
        3197 => ['MMMCVCII'],
        3198 => ['MMMCVCIII'],
        3199 => ['MMMCVCIV', 'MMMCIC'],
        3245 => ['MMMCCVL'],
        3246 => ['MMMCCVLI'],
        3247 => ['MMMCCVLII'],
        3248 => ['MMMCCVLIII'],
        3249 => ['MMMCCVLIV', 'MMMCCIL'],
        3295 => ['MMMCCVC'],
        3296 => ['MMMCCVCI'],
        3297 => ['MMMCCVCII'],
        3298 => ['MMMCCVCIII'],
        3299 => ['MMMCCVCIV', 'MMMCCIC'],
        3345 => ['MMMCCCVL'],
        3346 => ['MMMCCCVLI'],
        3347 => ['MMMCCCVLII'],
        3348 => ['MMMCCCVLIII'],
        3349 => ['MMMCCCVLIV', 'MMMCCCIL'],
        3395 => ['MMMCCCVC'],
        3396 => ['MMMCCCVCI'],
        3397 => ['MMMCCCVCII'],
        3398 => ['MMMCCCVCIII'],
        3399 => ['MMMCCCVCIV', 'MMMCCCIC'],
        3445 => ['MMMCDVL'],
        3446 => ['MMMCDVLI'],
        3447 => ['MMMCDVLII'],
        3448 => ['MMMCDVLIII'],
        3449 => ['MMMCDVLIV', 'MMMCDIL'],
        3450 => ['MMMLD'],
        3451 => ['MMMLDI'],
        3452 => ['MMMLDII'],
        3453 => ['MMMLDIII'],
        3454 => ['MMMLDIV'],
        3455 => ['MMMLDV'],
        3456 => ['MMMLDVI'],
        3457 => ['MMMLDVII'],
        3458 => ['MMMLDVIII'],
        3459 => ['MMMLDIX'],
        3460 => ['MMMLDX'],
        3461 => ['MMMLDXI'],
        3462 => ['MMMLDXII'],
        3463 => ['MMMLDXIII'],
        3464 => ['MMMLDXIV'],
        3465 => ['MMMLDXV'],
        3466 => ['MMMLDXVI'],
        3467 => ['MMMLDXVII'],
        3468 => ['MMMLDXVIII'],
        3469 => ['MMMLDXIX'],
        3470 => ['MMMLDXX'],
        3471 => ['MMMLDXXI'],
        3472 => ['MMMLDXXII'],
        3473 => ['MMMLDXXIII'],
        3474 => ['MMMLDXXIV'],
        3475 => ['MMMLDXXV'],
        3476 => ['MMMLDXXVI'],
        3477 => ['MMMLDXXVII'],
        3478 => ['MMMLDXXVIII'],
        3479 => ['MMMLDXXIX'],
        3480 => ['MMMLDXXX'],
        3481 => ['MMMLDXXXI'],
        3482 => ['MMMLDXXXII'],
        3483 => ['MMMLDXXXIII'],
        3484 => ['MMMLDXXXIV'],
        3485 => ['MMMLDXXXV'],
        3486 => ['MMMLDXXXVI'],
        3487 => ['MMMLDXXXVII'],
        3488 => ['MMMLDXXXVIII'],
        3489 => ['MMMLDXXXIX'],
        3490 => ['MMMLDXL', 'MMMXD'],
        3491 => ['MMMLDXLI', 'MMMXDI'],
        3492 => ['MMMLDXLII', 'MMMXDII'],
        3493 => ['MMMLDXLIII', 'MMMXDIII'],
        3494 => ['MMMLDXLIV', 'MMMXDIV'],
        3495 => ['MMMLDVL', 'MMMXDV', 'MMMVD'],
        3496 => ['MMMLDVLI', 'MMMXDVI', 'MMMVDI'],
        3497 => ['MMMLDVLII', 'MMMXDVII', 'MMMVDII'],
        3498 => ['MMMLDVLIII', 'MMMXDVIII', 'MMMVDIII'],
        3499 => ['MMMLDVLIV', 'MMMXDIX', 'MMMVDIV', 'MMMID'],
        3545 => ['MMMDVL'],
        3546 => ['MMMDVLI'],
        3547 => ['MMMDVLII'],
        3548 => ['MMMDVLIII'],
        3549 => ['MMMDVLIV', 'MMMDIL'],
        3595 => ['MMMDVC'],
        3596 => ['MMMDVCI'],
        3597 => ['MMMDVCII'],
        3598 => ['MMMDVCIII'],
        3599 => ['MMMDVCIV', 'MMMDIC'],
        3645 => ['MMMDCVL'],
        3646 => ['MMMDCVLI'],
        3647 => ['MMMDCVLII'],
        3648 => ['MMMDCVLIII'],
        3649 => ['MMMDCVLIV', 'MMMDCIL'],
        3695 => ['MMMDCVC'],
        3696 => ['MMMDCVCI'],
        3697 => ['MMMDCVCII'],
        3698 => ['MMMDCVCIII'],
        3699 => ['MMMDCVCIV', 'MMMDCIC'],
        3745 => ['MMMDCCVL'],
        3746 => ['MMMDCCVLI'],
        3747 => ['MMMDCCVLII'],
        3748 => ['MMMDCCVLIII'],
        3749 => ['MMMDCCVLIV', 'MMMDCCIL'],
        3795 => ['MMMDCCVC'],
        3796 => ['MMMDCCVCI'],
        3797 => ['MMMDCCVCII'],
        3798 => ['MMMDCCVCIII'],
        3799 => ['MMMDCCVCIV', 'MMMDCCIC'],
        3845 => ['MMMDCCCVL'],
        3846 => ['MMMDCCCVLI'],
        3847 => ['MMMDCCCVLII'],
        3848 => ['MMMDCCCVLIII'],
        3849 => ['MMMDCCCVLIV', 'MMMDCCCIL'],
        3895 => ['MMMDCCCVC'],
        3896 => ['MMMDCCCVCI'],
        3897 => ['MMMDCCCVCII'],
        3898 => ['MMMDCCCVCIII'],
        3899 => ['MMMDCCCVCIV', 'MMMDCCCIC'],
        3945 => ['MMMCMVL'],
        3946 => ['MMMCMVLI'],
        3947 => ['MMMCMVLII'],
        3948 => ['MMMCMVLIII'],
        3949 => ['MMMCMVLIV', 'MMMCMIL'],
        3950 => ['MMMLM'],
        3951 => ['MMMLMI'],
        3952 => ['MMMLMII'],
        3953 => ['MMMLMIII'],
        3954 => ['MMMLMIV'],
        3955 => ['MMMLMV'],
        3956 => ['MMMLMVI'],
        3957 => ['MMMLMVII'],
        3958 => ['MMMLMVIII'],
        3959 => ['MMMLMIX'],
        3960 => ['MMMLMX'],
        3961 => ['MMMLMXI'],
        3962 => ['MMMLMXII'],
        3963 => ['MMMLMXIII'],
        3964 => ['MMMLMXIV'],
        3965 => ['MMMLMXV'],
        3966 => ['MMMLMXVI'],
        3967 => ['MMMLMXVII'],
        3968 => ['MMMLMXVIII'],
        3969 => ['MMMLMXIX'],
        3970 => ['MMMLMXX'],
        3971 => ['MMMLMXXI'],
        3972 => ['MMMLMXXII'],
        3973 => ['MMMLMXXIII'],
        3974 => ['MMMLMXXIV'],
        3975 => ['MMMLMXXV'],
        3976 => ['MMMLMXXVI'],
        3977 => ['MMMLMXXVII'],
        3978 => ['MMMLMXXVIII'],
        3979 => ['MMMLMXXIX'],
        3980 => ['MMMLMXXX'],
        3981 => ['MMMLMXXXI'],
        3982 => ['MMMLMXXXII'],
        3983 => ['MMMLMXXXIII'],
        3984 => ['MMMLMXXXIV'],
        3985 => ['MMMLMXXXV'],
        3986 => ['MMMLMXXXVI'],
        3987 => ['MMMLMXXXVII'],
        3988 => ['MMMLMXXXVIII'],
        3989 => ['MMMLMXXXIX'],
        3990 => ['MMMLMXL', 'MMMXM'],
        3991 => ['MMMLMXLI', 'MMMXMI'],
        3992 => ['MMMLMXLII', 'MMMXMII'],
        3993 => ['MMMLMXLIII', 'MMMXMIII'],
        3994 => ['MMMLMXLIV', 'MMMXMIV'],
        3995 => ['MMMLMVL', 'MMMXMV', 'MMMVM'],
        3996 => ['MMMLMVLI', 'MMMXMVI', 'MMMVMI'],
        3997 => ['MMMLMVLII', 'MMMXMVII', 'MMMVMII'],
        3998 => ['MMMLMVLIII', 'MMMXMVIII', 'MMMVMIII'],
        3999 => ['MMMLMVLIV', 'MMMXMIX', 'MMMVMIV', 'MMMIM'],
    ];

    private const THOUSANDS = ['', 'M', 'MM', 'MMM'];
    private const HUNDREDS = ['', 'C', 'CC', 'CCC', 'CD', 'D', 'DC', 'DCC', 'DCCC', 'CM'];
    private const TENS = ['', 'X', 'XX', 'XXX', 'XL', 'L', 'LX', 'LXX', 'LXXX', 'XC'];
    private const ONES = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX'];
    const MAX_ROMAN_VALUE = 3999;
    const MAX_ROMAN_STYLE = 4;

    private static function valueOk(int $aValue, int $style): string
    {
        $origValue = $aValue;
        $m = \intdiv($aValue, 1000);
        $aValue %= 1000;
        $c = \intdiv($aValue, 100);
        $aValue %= 100;
        $t = \intdiv($aValue, 10);
        $aValue %= 10;
        $result = self::THOUSANDS[$m] . self::HUNDREDS[$c] . self::TENS[$t] . self::ONES[$aValue];
        if ($style > 0) {
            if (array_key_exists($origValue, self::VALUES)) {
                $arr = self::VALUES[$origValue];
                $idx = min($style, count($arr)) - 1;
                $result = $arr[$idx];
            }
        }

        return $result;
    }

    private static function styleOk(int $aValue, int $style): string
    {
        return ($aValue < 0 || $aValue > self::MAX_ROMAN_VALUE) ? ExcelError::VALUE() : self::valueOk($aValue, $style);
    }

    public static function calculateRoman(int $aValue, int $style): string
    {
        return ($style < 0 || $style > self::MAX_ROMAN_STYLE) ? ExcelError::VALUE() : self::styleOk($aValue, $style);
    }

    /**
     * ROMAN.
     *
     * Converts a number to Roman numeral
     *
     * @param mixed $aValue Number to convert
     *                      Or can be an array of numbers
     * @param mixed $style Number indicating one of five possible forms
     *                      Or can be an array of styles
     *
     * @return array|string Roman numeral, or a string containing an error
     *         If an array of numbers is passed as an argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function evaluate($aValue, $style = 0)
    {
        if (is_array($aValue) || is_array($style)) {
            return self::evaluateArrayArguments([self::class, __FUNCTION__], $aValue, $style);
        }

        try {
            $aValue = Helpers::validateNumericNullBool($aValue);
            if (is_bool($style)) {
                $style = $style ? 0 : 4;
            }
            $style = Helpers::validateNumericNullSubstitution($style, null);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return self::calculateRoman((int) $aValue, (int) $style);
    }
}
