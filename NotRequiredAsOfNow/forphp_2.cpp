
//============================================================================
// Name        : 
// Author      : Atul Kumar Gupta
// Description : 
// Status	   : AC
//============================================================================

#include <bits/stdc++.h>

using namespace std;

#define mod 1000000007
#define dg(x) outfile << '>' << #x << ':' << x << endl;
#define sz(c)  (int) c.size()
#define all(c) c.begin(), c.end()
#define tr(container,it) for(__typeof(container.begin()) it = container.begin();it != container.end(); it++)
#define pii pair<int,int>
#define present(s,x) s.find(x) != s.end()
#define cpresent(c,x) find(all(c),x) != c.end()
#define pb push_back
#define mp make_pair
#define rep(i,n) for(int i=0;i<n;i++)
#define dep(i,n) for(int i=n-1;i>=0;i--)
#define repn(i,a,b) for(int i=a; i<b;i++)
#define ini(n) scanf("%d",&n)
#define ioa(n,a) { ini(n); rep(i,n) ini(a[i]) ;}
#define ind(n,m) scanf("%d %d",&n,&m);
#define inl(n) scanf("%l64d",&n)
#define ins(n) scanf("%s",n);
#define ina(n) cin>>n
#define opi(n) printf("%d",n)
#define opl(n) printf("%l64d",n)
#define ops(n) printf("%s",n)
#define opn outfile<<"\n"
#define opsp printf(" ");
#define opa(n) outfile<<n
 
//#define TRACE
 
#ifdef TRACE
#define trace1(x)                cerr << #x << ": " << x << endl;
#define trace2(x, y)             cerr << #x << ": " << x << " | " << #y << ": " << y << endl;
#define trace3(x, y, z)          cerr << #x << ": " << x << " | " << #y << ": " << y << " | " << #z << ": " << z << endl;
#define trace4(a, b, c, d)       cerr << #a << ": " << a << " | " << #b << ": " << b << " | " << #c << ": " << c << " | " << #d << ": " << d << endl;
#define trace5(a, b, c, d, e)    cerr << #a << ": " << a << " | " << #b << ": " << b << " | " << #c << ": " << c << " | " << #d << ": " << d << " | " << #e << ": " << e << endl;
#define trace6(a, b, c, d, e, f) cerr << #a << ": " << a << " | " << #b << ": " << b << " | " << #c << ": " << c << " | " << #d << ": " << d << " | " << #e << ": " << e << " | " << #f << ": " << f << endl;
 
#else
 
#define trace1(x)
#define trace2(x, y)
#define trace3(x, y, z)
#define trace4(a, b, c, d)    
#define trace5(a, b, c, d, e)
#define trace6(a, b, c, d, e, f)

#endif 

typedef pair<int,int> pi;
typedef vector<pi> vp;
typedef vector<vp> vvp;
typedef vector<int> vi;
typedef unsigned long long int ull;
typedef long long int ll;
typedef vector<ll> vl;
typedef vector< vi > vvi;
typedef priority_queue<pi> pq;
typedef priority_queue<int, vi , greater<int> >minpq;
typedef priority_queue<pi,vp,greater<pi> > mpq;

//Euclidean GCD
//------------------------------------------
//============================================================================
int gcd(int A, int B) {
    if(B==0)
        return A;
    else
        return gcd(B, A % B);
}
//Fermat MMI
//------------------------------------------
//============================================================================
//a^n % m
ll mod_exponentiation(ll base, ll exponent, int modulus)
{
    ll result = 1;
    while (exponent > 0)
    {
        if (exponent % 2 == 1)
            result = (result * base) % modulus;
        exponent = exponent >> 1;
        base = (base * base) % modulus;
    }
    return result;
}

int fermat(ll n, ll m){
	return mod_exponentiation(n,m-2,m);
}

struct node{
	vector<pi> owes;
	vector<pi> gets;
	int total_owed;
	int total_gets;
	int net;
}tree[10000];
//custom comparator
//struct Compare{
	//bool operator()(node &a, node &b){
		//return a.cnt > b.cnt ;
	//}
//};

//conversion
//============================================================================
//------------------------------------------
inline int toInt(string s) {int v; istringstream sin(s);sin>>v;return v;}
template<class T> inline string toString(T x) {ostringstream sout;sout<<x;return sout.str();}

//math
//-------------------------------------------
//============================================================================
template<class T> inline T sqr(T x) {return x*x;}


//Main Starts
//------------------------------------------
//============================================================================

ifstream infile("input.txt");
ofstream outfile("out.txt");
int visit[10000];
vector<vp>G(100000);
int cost[10000];

void cost_calculation(){
	for(int i=1;i<1000;i++){
		if(sz(G[i])){
			tr(G[i],it){
				if(!visit[i]){
					visit[i] = 1;
				}
				if(!visit[it->first]){
					visit[it->first] = 1;
				}
				//outfile<<it->first<<" "<<it->second<<" ";
				cost[i] += it->second;
				tree[i].gets.pb({it->first , it->second});
				tree[i].total_gets += it->second;
				cost[it->first] -= it->second;
				tree[it->first].owes.pb({i , it->second});
				tree[it->first].total_owed += it->second;
			}
			
		//	opn;
		}
	}
}
pq maxq;
mpq minq;
set<pi>s;
set<pi>::iterator it1,it2;

/*void simplify_debt(){
	int x=10;
	while( x--){
		pi maxc = *it2;
		trace2(maxc.first , maxc.second);
		pi minc = *it1;
		trace2(minc.first , minc.second);
		int mini = min(abs(maxc.first) , abs(minc.first));
		if(mini == abs(minc.first)){
			outfile<<minc.second<<" pays "<<maxc.second<<" amount "<<mini;
			opn;
			s.insert({maxc.first + minc.first , maxc.second});
			s.erase(maxc);
			s.erase(minc);
		}
		else{
			outfile<<minc.second<<" pays "<<maxc.second<<" amount "<<mini;
			opn;
			s.insert({maxc.first + minc.first , minc.second});
			s.erase(maxc);
			s.erase(minc);
		}
	}
	
}*/

void total_calculation(){
	for(int i=1;i<100;i++){
		if(tree[i].net || tree[i].total_gets || tree[i].total_owed){
			outfile<<"total owed by "<<i<<" "<<tree[i].total_owed;opn;
			outfile<<"total gets "<<i<<" "<<tree[i].total_gets;opn;
			tr(tree[i].gets,it){
				outfile<<i<<" gets from "<<it->first<<" amount of "<<it->second;
				opn;
			}
			tr(tree[i].owes,it){
				outfile<<i<<" owes to "<<it->first<<" amount of "<<it->second;
				opn;
			}
		}
		opn;
	}
	
}
void simplify_debt(){
	while(1){
		if(maxq.empty() || minq.empty()){
			break;
		}
		pi maxc = maxq.top();
		trace2(maxc.first , maxc.second);
		
		
		pi minc = minq.top();
		trace2(minc.first , minc.second);
		
		int mini = min(abs(maxc.first) , abs(minc.first));
		if(mini == abs(minc.first)){
			outfile<<minc.second<<" pays "<<maxc.second<<" amount "<<mini;
			opn;
			minq.pop();
			maxq.pop();
			trace1("popping from maxxq");
			trace3("new to p is" , maxq.top().first , maxq.top().second);
			maxq.push({maxc.first + minc.first , maxc.second});
			trace3("pushing into maxx",maxc.first + minc.first , maxc.second);
		}
		else if(mini != abs(minc.first) && mini == abs(maxc.first)){
			outfile<<minc.second<<" pays "<<maxc.second<<" amount "<<mini;
			opn;
			maxq.pop();
			minq.pop();
			
			trace1("popping from minnq");
			trace3("new to p is" , minq.top().first , minq.top().second);
			minq.push({maxc.first + minc.first , minc.second});
			trace3("pushing into minnq",maxc.first + minc.first , minc.second);
		}
		else{
			outfile<<minc.second<<" pays "<<maxc.second<<" amount "<<mini;
			opn;
			maxq.pop();
			minq.pop();
			
			trace1("popping from minnq");
			trace3("new to p is" , minq.top().first , minq.top().second);
			//minq.push({maxc.first + minc.first , minc.second});
			//trace3("pushing into minnq",maxc.first + minc.first , minc.second);
			
		}
	}
}
int main(){
	it1 = s.begin();
	it2 = s.end();
	int a,b,c;
	while(infile>>a>>b>>c){
		G[a].pb({b,c});
	}
	cost_calculation();
	repn(i,1,100){
		if(visit[i]){
			trace2(cost[i],i);
			tree[i].net = cost[i];
			if(cost[i]>0){
				maxq.push({cost[i],i});
				//minq.push({cost[i],i});
			}
			else{
				//maxq.push({cost[i],i});
				minq.push({cost[i],i});
			}
			
		}
	}
	repn(i,1,100){
		if(visit[i]){
			trace2("visited are ", i);
			//s.insert(mp(cost[i],i));
			//trace3("pushing into s" , cost[i],i);
		}
	}
	//outfile<<s.begin()->first<<" ";
	opn;
	outfile<<"Printing Simplified Debt Information\n";
	simplify_debt();
	opn;
	outfile<<"Printing Detailed Information\n";
	total_calculation();
	
}

	

	
