


һ��	�����﷨
׼���ļ����£�
$ vi employee.txt
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager
�������ݰ�������ԱID   ��Ա����     ��Աְλ

1��Sed�����﷨��
Sed [options]  {sed-commands}{input-files}
Sedÿ�δ�input-file�ж�ȡһ�м�¼�����ڸü�¼��ִ��sed-comands��
sed���ȴ�input-file�ж�ȡ��һ�У�Ȼ��ִ�����е�sed-commands���ڶ�ȡ�ڶ��У�ִ������sed-commands���ظ�������̣�֪��input-file������
ͨ���ƶ�[options]�����Ը�sed����һЩ��ѡ��ѡ��
��ӡ/etc/passwd�ļ���������
sed 'p' /etc/passwd#��ӡ�ļ������У���ÿ���������
sed�Cn  'p' /etc/passwd#��ӡ�ļ������У�ÿ�����һ��

�������£�
sed  ��1,3p�� /etc/passwd#��ӡ���Ϊ�����У�ȫ�����
[root@cxp ~]# sed -n '1,5p'  /etc/passwd #��ӡҪ�������
root:x:0:0:root:/root:/bin/bash
bin:x:1:1:bin:/bin:/sbin/nologin
daemon:x:2:2:daemon:/sbin:/sbin/nologin
adm:x:3:4:adm:/var/adm:/sbin/nologin
lp:x:4:7:lp:/var/spool/lpd:/sbin/nologin
=?������ͣ�������Ŷ��	

2��ʹ��sed�ű��Ļ����﷨
sed [options] �Cf {sed-commands-in-a-file}{input-file}

��дsed�ű�����ӡ/etc/passwd����root��nobody��ͷ����
[root@cxp ~]# vim  test.sed
/^root/p
/^nobody/p
[root@cxp ~]# sed  -n -f test.sed  /etc/passwd#-fָ���ű��ļ�-nͬ��
root:x:0:0:root:/root:/bin/bash
nobody:x:99:99:Nobody:/:/sbin/nologin


3��ʹ��-eѡ�ִ�ж��sed����
sed[options]�Ce {sed-commands-1} �Ce{sed-commands-2}{input-file}

sed �Cn �Ce ��/^root/p��-e ��/^nobody/p��  /etc/passwd
[root@cxp ~]# sed  -n  -e '/^root/p' -e '/^nobody/p' /etc/passwd
root:x:0:0:root:/root:/bin/bash
nobody:x:99:99:Nobody:/:/sbin/nologin

Ҳ����������      #��\�ָ�
Sed �Cn \
-e ��/^root/ p�� \
-e ��/^nobody/ p�� \
/etc/passwd

������������  #ʹ��{}���������
Sed -n ��{
/^root/p
/^nobody/p
}�� /etc/passwd

ע�⣺sed����������޸�Դ�ļ�����ֻ�ǽ���������������׼����豸�����Ҫ���ֱ����Ӧ��ʹ���ض���>filename.txt



����	sed�ű�ִ������
sed�ű�ִ���������������׼ǵ�˳��Read��Execute��Print��Repeat����ȡ��ִ�У���ӡ���ظ������REPR��
�����ű�ִ��˳��
*��ȡһ�е�ģʽ�ռ䣨sed�ڲ���һ����ʱ���棬���ڴ�Ŷ�ȡ�������ݣ�
*��ģʽ�ռ���ִ��������ʹ����{}��-eָ���˶�����sed������ִ��ÿ������
*��ӡģʽ�ռ�����ݣ�Ȼ�����ģʽ�ռ�
*�ظ��������̣�ֱ���ļ�����

Sedִ���������£�
 

��������ʵս
1��	��ӡģʽ�ռ䣨����p��
ʹ������p�����Դ�ӡ��ǰģʽ�ռ�����ݡ�
sed��ִ���������Ĭ�ϴ�ӡģʽ�ռ�����ݣ���Ȼ��ˣ���ôΪ�λ�Ҫ����p�أ�
������ԭ������p���Կ���ֻ���ָ�������ݡ�ͨ��ʹ��pʱ������Ҫʹ��-nѡ��������sed��Ĭ�����������ִ������pʱ��ÿ��������Σ�
[root@cxp ~]# sed 'p'  employee.txt 
101,John Doe,CEO
101,John Doe,CEO
102,Jason Smith,IT Manager
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
104,Anand Ram,Developer
105,Jane Miller,Sales Manager
105,Jane Miller,Sales Manager

[root@cxp ~]# sed -n  'p'  employee.txt #����ԱȺ�����
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

2��	ָ����ַ��Χ
�����������ǰ�治ָ����ַ��Χ����ôĬ�ϻ�ƥ�������С�
[root@cxp ~]# sed  -n '2p'  employee.txt   #ֻ��ӡ�ڶ���
102,Jason Smith,IT Manager

[root@cxp ~]# sed -n '1,4p'  employee.txt #��ӡ1,4��
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer

[root@cxp ~]# sed -n '2,$p'  employee.txt #��ӡ2�����һ��
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager
                                  ==?�˴�Ϊ����
�޸ĵ�ַ��Χ��
	����ʹ�ö��š��Ӻš��Ͳ��˺����޸ĵ�ַ��Χ��

������������棬���Ѿ�������ʹ���˶��Ų����ַ��Χ��ָ������˼��n��m�����n����m�С�

�Ӻ�+��϶���ʹ�ã�����ָ����������У������Ǿ��Եļ��С��磺n��+m��ʾ�ӵ�n�п�ʼ���m��

���˺�~Ҳ����ָ����ַ��Χ����ָ��ÿ��Ҫ�������������磺n~m��ʾ�ӵ�n�п�ʼ��ÿ������m�С�
[root@cxp ~]# sed -n '1~2p'  employee.txt  #ֻ��ӡ����
101,John Doe,CEO
103,Raj Reddy,Sysadmin
105,Jane Miller,Sales Manager

3��	ƥ��ģʽ
��ӡƥ��ģʽ��Jane������
[root@cxp ~]# sed -n '/Jane/p' employee.txt 
105,Jane Miller,Sales Manager

��ӡ��һƥ��Jason���е���4�е����ݣ�
[root@cxp ~]# sed -n '/Jason/,4p' employee.txt 
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer

ע�⣺�����ʼ��4���У�û��ƥ�䵽Jason����ôsed��ӡ��4���Ժ�ƥ�䵽��Json������

��ӡ�ӵ�һ��ƥ�䵽��Raj���е����������У�
[root@cxp ~]# sed -n '/Raj/,$p'  employee.txt 
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

��ӡƥ��Jason���к����������У�
[root@cxp ~]# sed -n '/Jason/,+2p' employee.txt 
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer

4��	ɾ����
����d����ɾ���У���Ҫע�������ֻ��ɾ���ռ�ģʽ�����ݣ�������sed����һ��������d�����޸�ԭʼ�ļ������ݡ�
������ṩ��ַ��Χ��sedĬ��ƥ�������У��������������ʲô�������������Ϊ��ƥ���������в�ɾ�������ǣ�
sed  ��d�� employee.txt
ָ��ɾ���ĵ�ַ�����á�
ֻɾ����2��
[root@cxp ~]# sed  '2d' employee.txt 
101,John Doe,CEO
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

[root@cxp ~]# cat   employee.txt    #Դ�ļ����ݲ�û�иı�
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

ɾ����1��4�У�
[root@cxp ~]# sed '1,4d'  employee.txt 
105,Jane Miller,Sales Manager

ɾ����2�������һ�У�
[root@cxp ~]# sed '2,$d'  employee.txt 
101,John Doe,CEO

ֻɾ�������У�
[root@cxp ~]# sed '1~2d'  employee.txt 
102,Jason Smith,IT Manager
104,Anand Ram,Developer

ɾ����һ��ƥ�䵽��Jason��������4�У�
[root@cxp ~]# sed '/Jason/,4 d'   employee.txt 
101,John Doe,CEO
105,Jane Miller,Sales Manager

ע�⣺�����ͷ��4���У�û��ƥ�䵽Jason���У���ô�������ɾ����4���Ժ�ƥ��Jason����

ɾ�����п��У�
[root@cxp ~]# sed '/^$/d'  employee.txt #ƥ�����
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

ɾ������ע���У��ٶ���#��ͷ��
sed ��/^#/d��  employee.txt

ע�⣺����ж�����sed��������dʱ����ɾ��ƥ�䵽���������ݣ����������޷�������ɾ�����С�

5��	��ģʽ�ռ�����д���ļ��У�w���
����w���԰ѵ�ǰģʽ�ռ�����ݱ��浽�ļ��С�Ĭ�������ģʽ�ռ������ÿ�ζ����ӡ����׼��������Ҫ��������浽�ļ�ͬʱ����ʾ����Ļ�ϣ�����Ҫʹ��-nѡ�
��employmee.txt�����ݱ��浽output.txt��ͬʱ��ʾ����Ļ�ϣ�
[root@cxp ~]# sed 'w output.txt'  employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

[root@cxp ~]# cat  output.txt
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

��employmee.txt�����ݱ��浽output.txt��ͬʱ����ʾ����Ļ�ϣ�
[root@cxp ~]# sed  -n 'w output.txt'  employee.txt
#����

ֻ�����2�У�
[root@cxp ~]# sed '2 w output.txt' employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

[root@cxp ~]# cat  output.txt
102,Jason Smith,IT Manager

#���������������

6��	sed�滻����
�����﷨��
sed��address-range|pattern-range]s/original-string/replacement-string/[substitute-flags]�� input file
�����ᵽ���﷨Ϊ��
?address-range��pattern-range������ַ��Χ��ģʽ��Χ���ǿ�ѡ�ġ����û��ָ������ôsed���������н����滻��
?s��ִ���滻����substitue
?original-string�Ǳ�sed����Ȼ���滻���ַ�������������һ��������ʽ
?replacement-string�滻����ַ���
?substitue-flags�ǿ�ѡ�ģ�����������

ע�⣺ԭʼ�ļ������ݲ��ᱻ�޸ģ�sedֻ��ģʽ�ռ���ִ���滻���Ȼ�����ģʽ�ռ�����ݡ�

��Director�滻�������е�Manager��
[root@cxp ~]# sed 's/Manager/Director/' employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Director
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Director

ֻ�Ѱ���Sales�����е�Manager�滻ΪDirector
[root@cxp ~]# sed '/Sales/s/Manager/Director/' employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Director

7��g����ȫ�֣�global��Ĭ������£�sed�����滻ÿ���е�һ�γ��ֵ�original-string��
�ô�д��A�滻��һ�γ��ֵ�Сдa��
[root@cxp ~]# sed  's/a/A/' employee.txt 
101,John Doe,CEO
102,JAson Smith,IT Manager
103,RAj Reddy,Sysadmin
104,AnAnd Ram,Developer
105,JAne Miller,Sales Manager

�����е�Сд��ĸa�滻Ϊ��д��A��
[root@cxp ~]# sed 's/a/A/g'  employee.txt 
101,John Doe,CEO
102,JAson Smith,IT MAnAger
103,RAj Reddy,SysAdmin
104,AnAnd RAm,Developer
105,JAne Miller,SAles MAnAger

8��	���ֱ�־��1,2,3....��
ʹ�����ֿ���ָ��original-string���ֵĴ���ֻ�е�n�γ��ֵ�original-string�Żᴥ���滻��ÿ�е����ִ�1��ʼ�����Ϊ512.
�ѵ�2�γ��ֵ�Сд��ĸa�滻Ϊ��д��ĸA��
[root@cxp ~]# sed 's/a/A/2'  employee.txt 
101,John Doe,CEO
102,Jason Smith,IT MAnager
103,Raj Reddy,SysAdmin
104,Anand RAm,Developer
105,Jane Miller,SAles Manager

Ϊ�˷��������ʾ�������Ƚ��������ļ���
[root@cxp ~]#vim substitute-locate.txt
locate command is used to locate files
locate command uses database to locate files
locate command can also use regex for searching

ʹ�øղŽ������ļ�����ÿ���еڶ��γ��ֵ�locate�滻Ϊfind��
[root@cxp ~]# sed 's/locate/find/2'   substitute-locate.txt 
locate command is used to find files
locate command uses database to find files
locate command can also use regex for searching

9��	��ӡ��־��print��
����p�����ӡprint�����滻������ɺ󣬴�ӡ�滻���У���������ӡ�������ƣ�sed�бȽ����õķ����Ǻ�-nһ��ʹ��������Ĭ�ϵĴ�ӡ������

ֻ��ӡ�滻����У�
[root@cxp ~]# sed -n  's/John/johnny/p' employee.txt 
101,johnny Doe,CEO

��֮ǰ�����ֱ�־�������У�ʹ��/2���滻�ڶ��γ��ֵ�locate����3����locateֻ������һ�Σ�����û���滻�κ����ݡ�ʹ��p��־����ֻ��ӡ�滻�������С�

��ÿ���е�2�γ��ֵ�locate�滻Ϊfind����ӡ������
[root@cxp ~]# sed -n 's/locate/find/2p'  substitute-locate.txt 
locate command is used to find files
locate command uses database to find files


10��	д��־
��־w����write�����滻����ִ�гɹ��������滻�Ľ�����浽�ļ��С������˸�������ʹ��p��ӡ���ݣ�Ȼ���ض����ļ��С�Ϊ��sed��־�и�������������������������־Ҳ�������

ֻ���滻������д��output.txt�У�
[root@cxp ~]# sed -n 's/John/hello/w output.txt' employee.txt 
[root@cxp ~]# cat  output.txt
101,hello Doe,CEO

��ÿ�е�2�γ��ֵ�locate�滻Ϊfind�����滻�Ľ�����浽�ļ��У�ͬʱ��ʾ�����ļ��������ݣ�
[root@cxp ~]# sed 's/locate/find/2w output.txt'  substitute-locate.txt 
locate command is used to find files
locate command uses database to find files
locate command can also use regex for searching

ע�⣺���������Ƿ������ֻ������-n������

11��	���Դ�Сд��־i��ignore��
�滻��־i������Դ�Сд��������i����Сд�ַ���ģʽƥ��original-string���ñ�־ֵ��GNU sed�вſ���ʹ�á�

��������Ӳ����John�滻ΪJohnny����Ϊ�滻original-string�ַ�����Сд��ʽ��
[root@cxp ~]# sed 's/John/Johnny/'  employee.txt 
101,Johnny Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

��John��john�滻ΪJohnny��
[root@cxp ~]# sed 's/john/johnny/i'  employee.txt 
101,johnny Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

12��	ִ�������־e��excute��
�滻��־e����excute���ñ�־���Խ�ģʽ�ռ��е��κ����ݵ���shell����ִ�У���������ִ�еĽ�����ص�ģʽ�ռ䡣�ñ�־ֻ��GNU sed�вſ���ʹ�á�

Ϊ���������ӣ��Ƚ��������ļ���
[root@cxp ~]#cat files.txt
/etc/passwd
/etc/group

��files.txt�ļ��е�ÿ��ǰ�����ls �Cl ���ѽ����Ϊ����ִ�У�
[root@cxp ~]# sed 's/^/ls -l /'  files.txt
ls -l /etc/passwd
ls -l /etc/group

��files.txt�ļ��е�ÿ��ǰ�����ls �Cl���ѽ����Ϊ����ִ�У�
[root@cxp ~]# sed  's/^/ls -l /e'  files.txt #ע�����������ӿո�
-rw-r--r--. 1 root root 1230 Mar 27 20:59 /etc/passwd
-rw-r--r--. 1 root root 617 Mar 27 20:59 /etc/group

13��	ʹ���滻��־���
������Ҫ���԰�һ�������滻��־�������ʹ�á�

��ÿ���еĳ��ֵ�����Manager��manager�滻ΪDirector��Ȼ����滻������ݴ�ӡ����Ļ�ϣ�ͬʱ����Щ���ݱ��浽output.txt�ļ��У�
ʹ��g��l��p��w����ϣ�
[root@cxp ~]# sed -n 's/manager/Director/igpw output.txt'   employee.txt 
102,Jason Smith,IT Director
105,Jane Miller,Sales Director
[root@cxp ~]# cat  output.txt
102,Jason Smith,IT Director
105,Jane Miller,Sales Director

14��	�滻����ֽ��
�������е������У����Ƕ���ʹ��sed��Ĭ�Ϸֽ��/����s/original-string/replace-string/g
�����original-string��replace-string����/����ô��Ҫʹ��\��ת�塣Ϊ�˷���ʾ�������Ƚ���������ļ���
[root@cxp ~]#vim path.txt
reading /usr/local/bin directory	

����ʹ��sed��/usr/local/bin�滻Ϊ/usr/bin�������������У�sedĬ�ϵķֽ��/����\ת���ˣ�
[root@cxp ~]# sed 's/\/usr\/local\/bin/\/usr\/bin/' path.txt 
reading /usr/bin directory

���ѿ������Ҫ�滻һ���ܳ���·����ÿ��/ǰ�涼ʹ��\ת�壬���Եĺܻ��ҡ����˵��ǣ������ʹ���κ�һ���ַ�����Ϊsed�滻����ķֽ�����磺|^@!

��������ӾͱȽ��׶��ˣ�
[root@cxp ~]# sed -n 's@/usr/local/bin@/usr/bin@p' path.txt 
reading /usr/bin directory

15��	����������ִ�ж������
Sedִ�еĹ����Ƕ�ȡ���ݡ�ִ�������ӡ������ظ�ѭ��������ִ������֣������ɶ������ִ�У�sed��һ��һ��������ִ�����ǡ�

���磺�����������sed����ģʽ�ռ���ִ�е�һ�����Ȼ����ִ�еڶ�����������һ������ı���ģʽ�ռ�����ݣ��ڶ���������ڸı���ģʽ�ռ���ִ�У���ʱģʽ�ռ�������Ѿ������ʼ�Ķ�ȡ�����ˣ���

������ʾ����ģʽ�ռ���ִ�������滻����Ĺ��̣�
��Developer�滻ΪIT Manager��Ȼ���Manager�滻ΪDirector��
[root@cxp ~]# sed -e 's/Developer/IT Manager/' -e 's/Manager/Director/'  employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Director
103,Raj Reddy,Sysadmin
104,Anand Ram,IT Director
105,Jane Miller,Sales Director

������������
[root@cxp ~]# sed '{ #����Ҫ��\���з�
>s/Developer/IT Manager/
>s/Manager/Director/
> }'  employee.txt
101,John Doe,CEO
102,Jason Smith,IT Director
103,Raj Reddy,Sysadmin
104,Anand Ram,IT Director
105,Jane Miller,Sales Director

����һ�µ�4�е�ִ�й��̣�
A����ȡ���ݣ�����һ����sed��ȡ���ݵ�ģʽ�ռ䣬��ʱģʽ�ռ������Ϊ��104,Anand Ram,IT Developer
B��ִ�������һ�����s/Developer/IT Manager/ִ�к�ģʽ�ռ������Ϊ��104,Anand Ram,IT Manager
������ģʽ�ռ���ִ�еڶ�������s/Manager/Director/��ִ�к�ģʽ�ռ�����Ϊ��104,Anand Ram,IT Director
���ǣ�sed�ڵ�һ������ִ�еĽ���ϣ�ִ�еڶ�������
C����ӡ���ݣ���ӡ��ǰģʽ�ռ�����ݣ����£�
104,Anand Ram,IT Director
D���ظ�ѭ�����ƶ��������ļ�����һ�У�Ȼ���ظ�ִ�е�һ��������ȡ����


16��&������----��ȡƥ�䵽��ģʽ
��replace-string��ʹ��&ʱ�������滻��ƥ�䵽��original-string��������ʽ�����Ǻ����õĶ�����

����ԱID������һ�е�3�����֣�����[]����101�ĳ�[101]:
[root@cxp ~]# sed 's/^[0-9][0-9][0-9]/[&]/g' employee.txt 
[101],John Doe,CEO
[102],Jason Smith,IT Manager
[103],Raj Reddy,Sysadmin
[104],Anand Ram,Developer
[105],Jane Miller,Sales Manager

��ÿһ�зŽ�<>�У�
[root@cxp ~]# sed 's/^.*/<&>/' employee.txt 
<101,John Doe,CEO>
<102,Jason Smith,IT Manager>
<103,Raj Reddy,Sysadmin>
<104,Anand Ram,Developer>
<105,Jane Miller,Sales Manager>

17��	�����滻���������飩
����������ʽ��һ����sed��Ҳ����ʹ�÷��顣������\(��ʼ����\)����������������ڻ��������С�
�������ü�����ʹ�÷���ѡ��Ĳ���������ʽ����sed�滻�����replace-string�к�������ʽ�У�������ʹ�û������á�

�������飺
[root@cxp ~]# sed 's@\([^,]*\).*@\1@g' employee.txt 
101
102
103
104
105
���������У�
?������ʽ\([^,]*\)ƥ���ַ�����ͷ��ʼ����һ������֮��������ַ�������������һ���У�
?replace-string�е�\1�����ƥ�䵽�ķ���
?g��ȫ�ֱ�־

�����������ֻ����ʾ/etc/passwd�ĵ�һ�У����û�����
[root@cxp ~]# sed 's/\([^:]*\).*/\1/g'  /etc/passwd
root
bin
daemon
adm
lp
sync
shutdown
������ʡ��

������ʵ�һ��Ϊ��д����ô��������д�ַ����ϣ���:
[root@cxp ~]# echo "The Geek Stuff"|sed 's/\(\b[A-Z]\)/\(\1\)/g'  
(T)he (G)eek (S)tuff # \b�߽��

���Ƚ��������ļ����Ա�ʾ��ʹ�ã�
[root@cxp ~]#vim numbers.txt
1
12
123
1234
12345
123456

��ʽ�����֣�������ɶ��ԣ�
[root@cxp ~]# sed  's/\(^\|[^0-9.]\)\([0-9]\+\)\([0-9]\{3\}\)/\1\2,\3/g'  numbers.txt 
1
12
123
1,234
12,345
123,456

18��	�����滻��������飩
����ʹ�ö��\(��\)���ַ��飬ʹ�ö������ʱ����Ҫ��replace-string��ʹ��\n��ָ����n�����顣

ֻ��ӡ��һ�У���ԱID���͵����У���Աְλ����
[root@cxp ~]# sed 's/^\([^,]*\),\([^,]*\),\([^,]*\)/\1,\3/g'  employee.txt 
101,CEO
102,IT Manager
103,Sysadmin
104,Developer
105,Sales Manager

����������У����Կ�����original-string�У�������3�����飬�Զ��ŷָ���
?\([^,]*\)��һ�����飬ƥ��Ա��ID
?	��Ϊ�ֶηָ���
?	\([^,]*\)�ڶ������飬ƥ���Ա����
?	��Ϊ�ֶηָ���
?	\([^,]*\)���������飬ƥ���Աְλ
?	��Ϊ�ֶηָ����������������ʾ�����ʹ�÷���
?	\1����һ�����飨��ԱID��
?	�������ڵ�һ������֮��Ķ���
?	\3����ڶ������飨��Աְλ��

ע�⣺sed����ܴ���9�����飬�ֱ���\1��\9��ʾ��

������һ�У���ԱID���͵ڶ��У���Ա��������
[root@cxp ~]# sed 's/^\([^,]*\),\([^,]*\),\([^,]*\)/\2,\1,\3/' employee.txt
John Doe,101,CEO
Jason Smith,102,IT Manager
Raj Reddy,103,Sysadmin
Anand Ram,104,Developer
Jane Miller,105,Sales Manager

19��	������ʽ
�п�ͷ�ģ�^��  ƥ��ÿһ�еĿ�ͷ
��ʾ��103��ͷ���У�
[root@cxp ~]# sed -n '/^103/p'  employee.txt 
103,Raj Reddy,Sysadmin

�еĽ�β��$��  ƥ���еĽ�β
��ʾ���ַ�r��β���У�
[root@cxp ~]# sed -n '/r$/p'  employee.txt 
102,Jason Smith,IT Manager
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

�����ַ���.�� ƥ������з�֮������ⵥ���ַ�
.ƥ�䵥���ַ�
..ƥ�������ַ�
��������

ģʽ��J����������ַ�����һ���ո񡱽����滻Ϊ��Jason����һ���ո񡱡����ԡ�J������ͬʱƥ��employee.txt�ļ��еġ�Jhon���͡�Jane�����滻������£�
[root@cxp ~]# sed -n 's/J.../Jason/p' employee.txt 
101,Jason Doe,CEO
102,Jasonn Smith,IT Manager
105,Jason Miller,Sales Manager

ƥ����λ��Σ�*��--�Ǻ�*ƥ�����������ǰ����ַ�����
�Ƚ��������ļ���
[root@cxp ~]# vim log.txt
log: input.txt
log:
log: testing resumed
log:
log:output created
��������鿴��Щ����log���Һ�������Ϣ���У�log����Ϣ֮�������0�������ո�ͬʱ����鿴��Щlog������û���κ���Ϣ���С�

��ʾ����log�����Һ���log��������Ϣ���У�log����Ϣ֮������пո�
[root@cxp ~]# sed -n '/log:*../p'  log.txt #ע��ո�ĸ���
log: input.txt
log: testing resumed
log:output created

ƥ��һ�λ��Σ�\+�� ��\+��ƥ��һ�λ�����ǰ����ַ������磺�ո�\+��
��\+��ƥ������һ�������ո�

��ʾ����log������log��������һ�������ո�������У�
[root@cxp ~]# sed -n '/log: \+/p'  log.txt  #ע��\+ǰ��ӿո�
log: input.txt
log: testing resumed   #û��ƥ�䵽log����log:output created����

��λ�һ��ƥ�䣨\?��   \?ƥ��0�λ�һ����ǰ����ַ���
[root@cxp ~]# sed -n '/log:\?/p'  log.txt 
log: input.txt
log:
log: testing resumed
log:
log:output created

ת���ַ���\��
[root@cxp ~]# sed -n  '/127\.0\.0\.1/p'  /etc/hosts
127.0.0.1   localhost localhost.localdomain localhost4 localhost4.localdomain4

�ַ�����[0-9]��  �ַ���ƥ�䷽�����г��ֵ�����һ���ַ�
ƥ�����2��3����4���У�
[root@cxp ~]# sed -n '/[234]/p'  employee.txt 
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
�ڷ������У�����ʹ�����ӷ�-ָ��һ���ַ���Χ����[0123456789]������[0-9]��ʾ����ĸ������[a-z][A-Z]��ʾ���ȵȡ�

���������|�� �ܵ�����|����ƥ����������һ���ӱ��ʽ��
��ӡ����101���߰���102���У�
[root@cxp ~]# sed -n '/101\|102/p'  employee.txt #ע��ת��|
101,John Doe,CEO
102,Jason Smith,IT Manager

��׼ƥ��m�Σ�{m}��
��ӡ�����������ֵ��У���������ӡ�����У���
[root@cxp ~]# sed  -n '/[0-9]/p'  numbers.txt 
1
12
123
1234
12345
123456

��ӡ����5�����ֵ��У�
[root@cxp ~]# sed -n '/^[0-9]\{5\}$/p' numbers.txt 
12345
����
��ӡ����5�����ֵ��У�
[root@cxp ~]# sed -n 's/\([0-9]\{5\}\).\+/\1/p' numbers.txt 
12345

ƥ��m��n�Σ�{m��n}��  ����m�Σ����n�Σ�m��n�����Ǹ���������ҪС��255.

��ӡ��3��5��������ɵ��У�
[root@cxp ~]# sed -n '/^[0-9]\{3,5\}$/p' numbers.txt 
123
1234
12345

�ַ��߽磨\b��  \b����ƥ�䵥�ʿ�ͷ��\bxx�����β��xx\b���������ַ������\bthe\b��ƥ��the������ƥ��they��\bthe��ƥ��the��they��

���Ƚ��������ļ���
[root@cxp ~]# vim   words.txt
word matching using: the
word matching using: thethe
word matching using: they

ƥ�����the��Ϊ�������ʵ��У�
[root@cxp ~]# sed -n '/\bthe\b/p'  words.txt 
word matching using: the

ƥ����the��ͷ���У�
[root@cxp ~]# sed -n '/\bthe/p'  words.txt 
word matching using: the
word matching using: thethe
word matching using: they

�������ã�\n��---���ǻ��з�
ֻƥ���ظ�the���ε��У�
[root@cxp ~]# sed -n '/\(the\)\1/p'  words.txt 
word matching using: thethe

ͬ������\([0-9]\)\1��ƥ������������ͬ�����֣��磺11,22,33������

sed��ʹ��������ʽ��
��employee.txt��ÿ����������ַ��滻Ϊ��Not Defined����
[root@cxp ~]# sed -n 's/..$/,Not Defined/p' employee.txt 
101,John Doe,C,Not Defined
102,Jason Smith,IT Manag,Not Defined
103,Raj Reddy,Sysadm,Not Defined
104,Anand Ram,Develop,Not Defined
105,Jane Miller,Sales Manag,Not Defined

����html�ļ���
[root@cxp ~]#vim  test.html
<html><body><h1>Hello World!</h1></body></html>

���test.html�ļ��е�����HTML��ǩ��
[root@cxp ~]# sed 's/<[^>]*>//g' test.html 
Hello World!

ɾ������ע���кͿ��У�
[root@cxp ~]# sed -e 's/#.*//;/^$/d'  /etc/profile
pathmunge () {
case ":${PATH}:" in
        *:"$1":*)
            ;;
        *)
if [ "$2" = "after" ] ; then
                PATH=$PATH:$1
else
                PATH=$1:$PATH
fi
esac
}
ʡ�ԡ���������

ֻɾ��ע���У�
[root@cxp ~]# sed '/#.*/d'  /etc/profile



pathmunge () {
case ":${PATH}:" in
        *:"$1":*)
            ;;
        *)
if [ "$2" = "after" ] ; then
                PATH=$PATH:$1
else
                PATH=$1:$PATH
fi
esac
}
ʡ�ԡ�������

ʹ��sed��DOS��ʽ���ļ�ת��ΪUnix��ʽ��
sed  ��s/.$//�� filename  

20��	sed׷�����a��
ʹ������a������ָ��λ�õĺ���������С�

�﷨��sed��[address] a the-line-to-append�� input-file

�ں�������׷��һ�У�
[root@cxp ~]# sed '2 a 203,jack johnson,Engineer' employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
203,jack johnson,Engineer
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

���ļ���β׷��һ�У�
[root@cxp ~]# sed '$ a 106,jack johnson,Engineer'  employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager
106,jack johnson,Engineer

ע�⣺ԭ��û�м��к�

Ҳ����׷�Ӷ��У�
[root@cxp ~]# sed '/Jason/a\ #Ҳ������\n������
> 203��jack johnson,Engineer\
> 204, Mark Smith,Sales'  employee.txt
101,John Doe,CEO
102,Jason Smith,IT Manager
203��jack johnson,Engineer
204, Mark Smith,Sales
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

21��	�������i��
��������insert�����׷���������ƣ�ֻ��������ָ��λ��֮ǰ�����С�

�﷨��sed ��[address]i the-line-to-insert�� input-file

��employee.txt�ĵ�2��֮ǰ����һ�У�
[root@cxp ~]# sed '2 i 203,jack johnson,Engineer'  employee.txt 
101,John Doe,CEO
203,jack johnson,Engineer
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

Ҳ���Բ�����У�ͬ׷��һ����

22��	�޸����c��
�޸�����change����������ȡ�����С�

�﷨��sed��[address] c the-line-to-insert��  input-file

��������ȡ����2�У�
[root@cxp ~]# sed '2 c 202,jack johnson'  employee.txt 
101,John Doe,CEO
202,jack johnson
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

����ȡ��һ�У�
[root@cxp ~]# sed '/Raj/c \
> 203,jack johnson\
> 240,smith  ready'  employee.txt
101,John Doe,CEO
102,Jason Smith,IT Manager
203,jack johnson
240,smith  ready
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

23��	����a��i��c���ʹ��

�ڡ�Jason�� ����׷�ӡ�Jack johnson������ǰ����롰Mark Smith�����á�Joe Mason�������Jason����
[root@cxp ~]# sed '/Jason/{
a\
204,Jack Johnson,Engineer
i\
202,Mark Smith,Sales Engineer
c\
203,Joe Mason,Sysadmin
> }' employee.txt #�������롰}�� ����Ȼ�ᱨ��
101,John Doe,CEO
202,Mark Smith,Sales Engineer
203,Joe Mason,Sysadmin
204,Jack Johnson,Engineer
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

24��	��ӡ���ɼ��ַ���l��
����l���Դ�ӡ���ɼ����ַ��������Ʊ��\t��β��־$�ȡ�

���Ƚ��������ļ����ں������ԣ���ȷ���ֶ�֮��ʹ���Ʊ����tab�����ֿ���
[root@cxp ~]#vim tabfile.txt
fname First Name
lname Last Name
mname Middle Name

ʹ������l�����Ʊ����ʾΪ\t����β��־��ʾΪEOL:
[root@cxp ~]# sed -n 'l' tabfile.txt 
fname\tFirst Name$
lname\tLast Name$
mname\tMiddle Name$

�����l����ָ�������֣���ô���ڵ�n���ַ�����ʹ��һ�����ɼ��Զ����У�Ч�����£�
[root@cxp ~]# sed -n 'l 20'  employee.txt 
101,John Doe,CEO$
102,Jason Smith,IT \
Manager$
103,Raj Reddy,Sysad\
min$
104,Anand Ram,Devel\
oper$
105,Jane Miller,Sal\
es Manager$

ע�⣺�������ֻ��GNU sed����

25��	��ӡ�кţ�=��
����=����ÿһ�к�����ʾ���е��кš�

��ӡ�����кţ�
[root@cxp ~]# sed '='  employee.txt 
1
101,John Doe,CEO
2
102,Jason Smith,IT Manager
3
103,Raj Reddy,Sysadmin
4
104,Anand Ram,Developer
5
105,Jane Miller,Sales Manager

ֻ��ӡ1,2,3�е��кţ�
[root@cxp ~]# sed '1,3=' employee.txt 
1
101,John Doe,CEO
2
102,Jason Smith,IT Manager
3
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

��ӡ�����ؼ��֡�Jane�����е��кţ�ͬʱ��ӡ�����ļ������ݣ�
[root@cxp ~]# sed '/Jane/=' employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
5
105,Jane Miller,Sales Manager

ֻ��ʾ�кŲ���ʾ���ݣ���ôʹ��-nѡ�����������=��
[root@cxp ~]# sed -n '1=' employee.txt 
\1
[root@cxp ~]# sed -n '/Jane/=' employee.txt 
5

��ӡ�ļ�����������
[root@cxp ~]# sed  -n '$=' employee.txt 
6


26��	ת���ַ���y��
����y���ݶ�Ӧ��λ��ת���ַ����ô�֮һ���Ǵ�д�ַ�ת��ΪСд����֮��Ȼ��

��a��ΪA��b��λB��c��λC���������ƣ�
[root@cxp ~]# sed 'y/abcde/ABCDE/'  employee.txt 
101,John DoE,CEO
102,JAson Smith,IT MAnAgEr
103,RAj REDDy,SysADmin
104,AnAnD RAm,DEvElopEr
105,JAnE MillEr,SAlEs MAnAgEr #ע��������滻

������Сд�ַ��滻Ϊ��д�ַ���
[root@cxp ~]# sed 'y/abcdefghijklmnopqrstuvwxyz/ABCDEFGHIJKLMNOPQRSTUVWXYZ/' employee.txt 
101,JOHN DOE,CEO
102,JASON SMITH,IT MANAGER
103,RAJ REDDY,SYSADMIN
104,ANAND RAM,DEVELOPER
105,JANE MILLER,SALES MANAGER

[root@cxp ~]# sed 'y/[a-z]/[A-Z]/' employee.txt #ע��˷�ʽ����������滻
101,John Doe,CEO
102,JAson Smith,IT MAnAger
103,RAj Reddy,SysAdmin
104,AnAnd RAm,Developer
105,JAne Miller,SAles MAnAger



27��	��������ļ�

ͬʱ��/etc/passwd��/etc/group������root��
[root@cxp ~]# sed -n '/root/p'  /etc/passwd  /etc/group
root:x:0:0:root:/root:/bin/bash
operator:x:11:0:operator:/root:/sbin/nologin
root:x:0:

28��	�˳�sed��q��
������ֹ����ִ�е�����˳�sed��

֮ǰ�ᵽ��������sedִ�����̣���ȡ���ݡ�ִ�������ӡ������ظ�ѭ����
��sed����q����������˳�����ǰѭ���еĺ�������ᱻִ�У�Ҳ�������ѭ����

��ӡ��1�к��˳���
[root@cxp ~]# sed 'q' employee.txt 
101,John Doe,CEO

��ӡ5�к��˳���
[root@cxp ~]# sed '5 q' employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

��ӡ�����У�֪�������ؼ���Manager�˳����У�
[root@cxp ~]# sed '/Manager/q' employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager

ע�⣺q�����ָ����ַ��Χ����ģʽ��Χ����ֻ�����ڵ�����ַ���򵥸�ģʽ����
29��	���ļ��ж�ȡ���ݣ�r��
�ڴ��������ļ�ʱ������r�������һ���ļ���ȡ���ݣ�����ָ����λ�ô�ӡ������

����ȡlog.txt�����ݣ����ڴ�ӡemployee.txt���һ��֮�󣬰Ѷ�ȡ�����ݴ�ӡ����������ʵ�����������ϲ�Ȼ���ӡ����
[root@cxp ~]# sed '$ r log.txt'  employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager
log: input.txt
log:
log: testing resumed
log:
log:output created

Ҳ����ָ��һ��ģʽ
����ȡlog.txt�����ݣ�������ƥ�䡯Raj�����к����ӡ������
[root@cxp ~]# sed '/Raj/ r log.txt' employee.txt 
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
log: input.txt
log:
log: testing resumed
log:
log:output created
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

30��	����ѡ�-i��
sed�����޸������ļ���ֻ������ݴ�ӡ����׼���������ʹ��w���������д����ͬ���ļ��У�����ʹ��-i��ֱ���޸������ļ���

��ԭʼ�ļ�employee.txt�У���Johnny�滻John��
[root@cxp ~]# cat employee.txt #����ǰ
101,John Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

[root@cxp ~]# sed -i 's/John/Johnny/' employee.txt 

[root@cxp ~]# cat  employee.txt  #���ĺ�
101,Johnny Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

ִ�к�������ͬ����������޸�ǰ����ԭʼ�ļ���
[root@cxp ~]# sed -ibak 's/John/Johnny/'  employee.txt 
[root@cxp ~]# cat  employee.txt
101,Johnny Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

[root@cxp ~]# ls
anaconda-ks.cfg     output.txt
employee.txt        path.txt
employee.txtbak     substitute-locate.txt   #�����ļ�
files.txt           tabfile.txt
install.log         test.html
install.log.syslog  test.sed
log.txt             words.txt
numbers.txt

31��	����ѡ�-c��
��ѡ���-i���ʹ�á�ʹ��-iʱ��ͨ��������ִ����ɺ�sedʹ����ʱ�ļ������ָ��ĺ�����ݣ�Ȼ��Ѹ���ʱ�ļ�������Ϊ�����ļ�����������ı��ļ��������ߣ���ֵ��ǲ��Խ������ı��ļ������ߣ������cѡ����Ա����ļ������߲��䡣Ҳ����ʹ�á�copy�����档

����������ǵȼ۵ģ�
[root@cxp ~]#sed -ibak -c 's/John/Johnny/' employee.txt
[root@cxp ~]#sed --in-place=bak --copy ��s/John/Johnny/�� employee.txt

32��	ѡ�-l��length 
ָ���еĳ��ȣ���Ҫ��l�������ʹ�ã�ע�⣺ѡ��-l������-l����ҪŪ���ˣ������ᵽ������i��ѡ��iҲ��Ҫ���ʹ��-lѡ�ָ���г��ȡ�Ҳ����ʹ�á�line-length�����档

�����ǵȼ۵ģ�
[root@cxp ~]# sed -n --line-length=20 'l' employee.txt
101,Johnnynyny Doe,\
CEO$
102,Jason Smith,IT \
Manager$
103,Raj Reddy,Sysad\
min$
104,Anand Ram,Devel\
oper$
105,Jane Miller,Sal\
es Manager$
$

[root@cxp ~]# sed -n -l 20 'l' employee.txtע�⣺��һ��-l��ʾ���ǳ��ȡ�line-length���ڶ���l��ʾlist�г���ǰ�е�����
101,Johnnynyny Doe,\
CEO$
102,Jason Smith,IT \
Manager$
103,Raj Reddy,Sysad\
min$
104,Anand Ram,Devel\
oper$
105,Jane Miller,Sal\
es Manager$
$

���£�
[root@cxp ~]# sed -n  'l'  employee.txt
101,Johnnynyny Doe,CEO$
102,Jason Smith,IT Manager$
103,Raj Reddy,Sysadmin$
104,Anand Ram,Developer$
105,Jane Miller,Sales Manager$

ע�⣺������-lѡ��ͬ�������г���ͬ�������
[root@cxp ~]# sed  -n 'l 20'  employee.txt 
101,Johnnynyny Doe,\
CEO$
102,Jason Smith,IT \
Manager$
103,Raj Reddy,Sysad\
min$
104,Anand Ram,Devel\
oper$
105,Jane Miller,Sal\
es Manager$
$

33��	��ӡģʽ�ռ䣨n��
����n��ӡ��ǰģʽ�ռ�����ݣ�Ȼ��������ļ��ж�ȡ��һ�С����������ִ�й���������n����ô����ı�������ִ�����̡�

��ӡÿһ�е����ݣ�
[root@cxp ~]# sed -n 'p'  employee.txt
101,Johnnynyny Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

[root@cxp ~]# sed n employee.txt  #���ʹ�õ�һ��-nѡ��û�����
101,Johnnynyny Doe,CEO
102,Jason Smith,IT Manager
103,Raj Reddy,Sysadmin
104,Anand Ram,Developer
105,Jane Miller,Sales Manager

ע�⣺��Ҫ��-n��nŪ���ˣ�
sed���������ǣ���ȡ���ݡ�ִ�������ӡ������ظ�ѭ����
����n���Ըı�������̣���ӡ��ǰģʽ�ռ�����ݣ�Ȼ�����ģʽ�ռ䣬��ȡ��һ�н�����Ȼ�����ִ�к�������
��������nǰ�������������������£�
sed-command-1
sed-command-2
n
sed-command-3
sed-command-4
��������£�sed-command-1��sed-command-2���ڵ�ǰģʽ�ռ���ִ�У�Ȼ������n������ӡ��ǰģʽ�ռ�����ݣ������ģʽ�ռ䣬��ȡ��һ�еģ�Ȼ���sed-command-3��sed-command-4Ӧ�����µ�ģʽ�ռ�����ݡ�
